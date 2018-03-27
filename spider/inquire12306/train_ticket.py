#!/usr/bin/env python3
# -*- coding:utf-8 -*-

# 12306火车票查询

import requests
from pprint import pprint
from station_names import station_names
import time

header = {
    'User-Agent':
    'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_11_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/64.0.3282.186 Safari/537.36',
    'Cookie':
    'JSESSIONID=7C7F3264CA3ADEA7ED007C1F6E995BF0; _jc_save_wfdc_flag=dc; _jc_save_fromStation=%u5E7F%u5DDE%u5357%2CIZQ; _jc_save_fromDate=2018-03-29; _jc_save_toStation=%u5317%u4EAC%2CBJP; route=6f50b51faa11b987e576cdb301e545c4; BIGipServerotn=2564227338.50210.0000; _jc_save_toDate=2018-03-20'
}

# url = "https://kyfw.12306.cn/otn/leftTicket/queryZ?leftTicketDTO.train_date=2018-03-12&leftTicketDTO.from_station=IZQ&leftTicketDTO.to_station=XKS&purpose_codes=ADULT"

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
            'JSESSIONID=7C7F3264CA3ADEA7ED007C1F6E995BF0; _jc_save_wfdc_flag=dc; _jc_save_fromStation=%u5E7F%u5DDE%u5357%2CIZQ; _jc_save_fromDate=2018-03-29; _jc_save_toStation=%u5317%u4EAC%2CBJP; route=6f50b51faa11b987e576cdb301e545c4; BIGipServerotn=2564227338.50210.0000; _jc_save_toDate=2018-03-20'
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
        # 03-20 url 'https://kyfw.12306.cn/otn/leftTicket/queryO?leftTicketDTO.train_date={2018-03-29}&leftTicketDTO.from_station={IZQ}&leftTicketDTO.to_station={BJP}&purpose_codes=ADULT'
        res = requests.get(
            "https://kyfw.12306.cn/otn/leftTicket/queryO?leftTicketDTO.train_date={}&leftTicketDTO.from_station={}&leftTicketDTO.to_station={}&purpose_codes=ADULT".
            format(self.departure_time, self.station_names[self.from_station],
                   self.station_names[self.to_station]),
            headers=self.header,
            verify=False)

        if res.status_code == 200:
            print("code 1 succ!")
        else:
            print('code1 fffffffffffff')
        data = res.json()['data']['result']

        # pprint(data)
        for i in data:

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
                    station_no['to_s_no'],result['seat_type'])


                result['seat'] = seat

                # 随机暂停
                time.sleep(3)
                # pprint(seat)

            else:
                result['status'] = "0"

            pprint(result)

            # yield(self.check_station_no(result))

            # return result

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

    def check_seat(self, trans_no, from_s_no, to_s_no, seat_type):
        # url = 'https://kyfw.12306.cn/otn/leftTicket/queryTicketPrice?train_no={630000Z12208}&from_station_no={01}&to_station_no={15}&seat_types={1413}&train_date={2018-03-11}'
        data = requests.get(
            'https://kyfw.12306.cn/otn/leftTicket/queryTicketPrice?train_no={}&from_station_no={}&to_station_no={}&seat_types={}&train_date={}'.
            format(trans_no, from_s_no, to_s_no, seat_type, self.departure_time))

        res = data.json()['data']
        # pprint(res)
        # 遍历字典
        result = []
        for key in res:
            if key in self.seat_trans.keys():
                # print(self.seat_trans[key], res[key])
                result.append((self.seat_trans[key], res[key]))

        return result


        # def run(self):
        # pprint(self.trans_station_names)
        # data = [
        #     'S1gLKhSsxaBW2UHnqnTCv8zNMxiRkimhtDTGYzf4vWzo5InKDVCH74NHFSlFN%2BTMSOyys7wHa7Qk%0AlsV4aP6uQN4U1l3s%2BYhrU4m8bpCj9CnnrnZuC7HH6r%2FG1QLEocRsQWBtmyMk5FNyONG9OcE0IOVY%0AoBAccAuEWiMFr%2Ba2eGtnbEMladI29eGNFxY9M0kFxP2nvjmUGkT5RD%2FO6jO51Rrz4RUH2bUNH%2BPv%0A5Tpf4s1Oocpsbox%2FUqzUL0mbOttraFSSNQ%3D%3D',
        #     '预订', '800000K2320S', 'K229', 'KMM', 'XMS', 'GZQ', 'XMS', '20:38',
        #     '08:58', '12:20', 'Y',
        #     'lqPeUo%2BOnNiCB%2F2RxOAVwTJzV8wv4kVGYvzpJVggg7x%2FiBxt2NV4lGwj7NY%3D',
        #     '20180322', '3', 'M1', '21', '32', '0', '0', '', '', '', '1', '',
        #     '', '无', '', '无', '有', '', '', '', '', '10401030', '1413', '0'
        # ]

        # inf = "N"

        # is_same_day = ("当日抵达" if inf == "N" else "次日抵达")
        # print(is_same_day)


def main():
    trainTicket = TrainTicket(station_names, from_station, to_station,
                              departure_time)
    res = trainTicket.train_table()
    pprint(res)
    # trainTicket.run()


if __name__ == '__main__':
    main()
