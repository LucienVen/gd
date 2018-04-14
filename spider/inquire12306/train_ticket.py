#!/usr/bin/env python3
# -*- coding:utf-8 -*-

# 12306火车票查询


# TODO 修改成为接口模式（return 数据）

import requests
from pprint import pprint
from station_names import station_names
import time

header = {
    'User-Agent':
    'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_11_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/64.0.3282.186 Safari/537.36',
    'Cookie':
    'JSESSIONID=4DA515887C9399EF8B615DB6E0EE6D2F; _jc_save_wfdc_flag=dc; _jc_save_fromStation=%u5E7F%u5DDE%2CGZQ; _jc_save_toStation=%u53A6%u95E8%2CXMS; route=9036359bb8a8a461c164a04f8f50b252; BIGipServerotn=368050698.50210.0000; RAIL_EXPIRATION=1524004307486; RAIL_DEVICEID=P0N7kqC4Q0I3Pwd8Ekxl9G9sCrEYHKKdt25n65kBHOqpEMelQ9-4geyGkm0hdxQL-eBIkQVBIQbt5Zzgxh3WHPm_vZ6XTOtWCS5C9hHSPSCWYTOSnxse1DhHogjW95jK5RL3n1u0vsHM306GXg18s_hvGaTF38IE; _jc_save_fromDate=2018-04-14; _jc_save_toDate=2018-04-14'
}

from_station = input("your left station: ")
to_station = input('the station your want to arrival: ')
departure_time = input('departure time(example: 2018-03-01): ')


class TrainTicket():
    def __init__(self, station_names, from_station, to_station,
                 departure_time):
        self.header = {
            'User-Agent':
            'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_11_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/64.0.3282.186 Safari/537.36',
            'Cookie':
            'JSESSIONID=4DA515887C9399EF8B615DB6E0EE6D2F; _jc_save_wfdc_flag=dc; _jc_save_fromStation=%u5E7F%u5DDE%2CGZQ; _jc_save_toStation=%u53A6%u95E8%2CXMS; route=9036359bb8a8a461c164a04f8f50b252; BIGipServerotn=368050698.50210.0000; RAIL_EXPIRATION=1524004307486; RAIL_DEVICEID=P0N7kqC4Q0I3Pwd8Ekxl9G9sCrEYHKKdt25n65kBHOqpEMelQ9-4geyGkm0hdxQL-eBIkQVBIQbt5Zzgxh3WHPm_vZ6XTOtWCS5C9hHSPSCWYTOSnxse1DhHogjW95jK5RL3n1u0vsHM306GXg18s_hvGaTF38IE; _jc_save_fromDate=2018-04-14; _jc_save_toDate=2018-04-14'
        }

        self.station_names = station_names
        self.trans_station_names = {v: k for k, v in station_names.items()}

        self.from_station = from_station
        self.to_station = to_station
        self.departure_time = departure_time

        self.from_station_code = station_names[from_station]
        self.to_station_code = station_names[to_station]

        self.seat_trans = {
            "WZ": "无座",
            "A1": "硬座",
            "A2": "软座",
            "A3": "硬卧",
            "A4": "软卧",
            "A5": None,
            "A6": "高级软卧",
            "A9": "商务座/特等座",
            "F": "动卧",
            "O": "二等座",
            "M": "一等座"
        }

    def train_table(self):
        print(self.departure_time)
        print(self.station_names[self.from_station])
        print(self.station_names[self.to_station])
        
        res = requests.get(
            # 这里经常需要更改请求url
            "https://kyfw.12306.cn/otn/leftTicket/query?leftTicketDTO.train_date={}&leftTicketDTO.from_station={}&leftTicketDTO.to_station={}&purpose_codes=ADULT".format(self.departure_time, self.station_names[self.from_station],self.station_names[self.to_station]),headers=self.header,verify=False)
            
        if res.status_code == 200:
            print("code 1 succ!")
        else:
            print('code1 fffffffffffff')
        data = res.json()['data']['result']

        # 解析数据信息
        for i in data:
            # 把字符串用“|”分割成数组
            information = i.split('|')

            result = {
                'train': information[3],
                'train_code': information[2],
                'from_station': self.trans_station_names[information[6]],
                'to_station': self.trans_station_names[information[7]],
                'start_time': information[8],
                'end_time': information[9],
                'is_same_day': ("当天抵达" if information[11] == "N" else "隔日抵达"),
                'take_time': information[10],
                'seat_type': information[-2]
            }
            # print(information)
            if (information[0] != ''):
                result['status'] = "1"
                # 查询列车班次代号
                station_no = self.check_station_no(result['train_code'],
                                                   result['from_station'],
                                                   result['to_station'])
                # print(station_no)
                result['station_no'] = station_no

                # 查询座位及票务信息
                seat = self.check_seat(
                    result['train_code'], station_no['from_s_no'],
                    station_no['to_s_no'], result['seat_type'])

                result['seat'] = seat

                # 随机暂停
                time.sleep(3)
                # pprint(seat)

            else:
                result['status'] = "0"

            pprint(result)

            # yield(self.check_station_no(result))

            # return result

    # 查询列车站点号
    def check_station_no(self, trans_no, from_s, to_s):
        station_no = {}
        url = "https://kyfw.12306.cn/otn/czxx/queryByTrainNo?train_no=630000K8270J&from_station_telecode=GZQ&to_station_telecode=CDW&depart_date=2018-03-11"
        data = requests.get(
            "https://kyfw.12306.cn/otn/czxx/queryByTrainNo?train_no={}&from_station_telecode={}&to_station_telecode={}&depart_date={}".
            format(trans_no, self.station_names[from_s],
                   self.station_names[to_s], self.departure_time),
            headers=self.header,
            verify=False)

        res = data.json()['data']['data']
        # pprint(res)
        for i in res:

            if i['station_name'] == from_s:
                station_no['from_s_no'] = i['station_no']
            elif i['station_name'] == to_s:
                station_no['to_s_no'] = i['station_no']
            else:
                pass
        # print(station_no)
        return station_no

    # 查询列车座位类型与票价
    def check_seat(self, trans_no, from_s_no, to_s_no, seat_type):
        # url = 'https://kyfw.12306.cn/otn/leftTicket/queryTicketPrice?train_no={630000Z12208}&from_station_no={01}&to_station_no={15}&seat_types={1413}&train_date={2018-03-11}'
        data = requests.get(
            'https://kyfw.12306.cn/otn/leftTicket/queryTicketPrice?train_no={}&from_station_no={}&to_station_no={}&seat_types={}&train_date={}'.
            format(trans_no, from_s_no, to_s_no, seat_type,
                   self.departure_time))

        res = data.json()['data']
        # pprint(res)
        # 遍历字典
        result = []
        for key in res:
            if key in self.seat_trans.keys():
                # print(self.seat_trans[key], res[key])
                result.append((self.seat_trans[key], res[key]))

        return result


def main():
    trainTicket = TrainTicket(station_names, from_station, to_station,
                              departure_time)
    res = trainTicket.train_table()
    pprint(res)
    # trainTicket.run()


if __name__ == '__main__':
    main()
