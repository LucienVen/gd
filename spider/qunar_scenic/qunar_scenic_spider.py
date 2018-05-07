#!/usr/bin/env python3
# -*- coding:utf-8 -*-

# 去哪儿网厦门景点咨询爬虫

import requests
# from bs4 import BeautifulSoup
# import os
import json
from pprint import pprint
import pymysql
import time
# _i=RBTjeaInT1RQ818x6VRnzkg2BX_x; QN57=15194606642250.8287380340057549; cto_lwid=70964639-7e63-4c7e-a101-a90cab028f33; QN99=4248; QunarGlobal=10.86.213.151_-333dfea0_161e09bb782_-65fb|1519892167944; QN601=e1ac0fbb09327aab7c6839beea72956d; QN48=tc_f78638d6a3eebe2b_161e0a212cd_3a7f; QN1=O5cv5lqX3ltQpY9DDzuXAg==; QN73=3087-3088; __utmz=183398822.1521079863.13.3.utmcsr=hotel.qunar.com|utmccn=(referral)|utmcmd=referral|utmcct=/; Qs_lvt_55613=1521027097%2C1521080296%2C1521109509%2C1521169738%2C1521199829; Qs_pv_55613=1218768077151019500%2C751241521191590800%2C3876112245866533000%2C3406416473725596700%2C4417262540621707000; Hm_lvt_8fa710fe238aadb83847578e333d4309=1521017092,1521092575,1521181224,1521202569; QN300=organic; QN269=9CF8D2C1BE1611E781D4FA163E7BCC04; __utma=183398822.1406903920.1520047326.1521202570.1524593154.25; QN205=s%3Dgoogle; QN277=s%3Dgoogle; csrfToken=ErW6lxD1JpH5ZusCtaJiIEp5G4mvyd6i; QN163=0; Hm_lvt_75154a8409c0f82ecd97d538ff0ab3f3=1525019330; QN71=MTEzLjEwNS4xMjguMjUwOuW5v+S4nDox; Hm_lvt_15577700f8ecddb1a927813c81166ade=1524593159,1525019336; QN63=%E5%8E%A6%E9%97%A8%7C%E4%B8%AD%E5%9B%BD; QN67=463521%2C215910%2C16050%2C14414%2C12051%2C192051%2C457472; _vi=iXlZj1ohvmuQgErzSpviPDjzzVT67NdPQ8vrrk33iijNwKvXc1hc6_uKr8nbNNKNw69AXuAX37aKAGcZyKbXyeFbYFhmUV73DwdHsTTc7gasL5j89ubVLfBIRyUqA6otYP4wWhAxs4nYhdyYAy39Le0sTeV77tqXD1l4xB1wP9fp; Hm_lpvt_75154a8409c0f82ecd97d538ff0ab3f3=1525020827; QN58=1525019335423%7C1525020895003%7C13; Hm_lpvt_15577700f8ecddb1a927813c81166ade=1525020895; JSESSIONID=F8F13E359495EB9B10E79454EF4CE4CE; Request-Node=d91e13b8f8f03f1285d33bc904401fc7


def save2sql(**kwargs):
    data = kwargs
    # pprint(data['sightName'])
    # 保存进数据库
    config = {
        'host': '127.0.0.1',
        'port': 3306,
        'user': 'root',
        'password': '123456',
        'db': 'gd',
        'charset': 'utf8mb4',
        'cursorclass': pymysql.cursors.DictCursor
    }

    connection = pymysql.connect(**config)
    try:
        with connection.cursor() as cursor:
            sql = "insert into qunar_scenic2(name, sight_id, districts, address, point, intro, star, score,price, small_sight_img_url, status) VALUE (%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s)"
            cursor.execute(
                sql,
                (data['sightName'], data['sightId'], data['districts'],
                 data['address'], data['point'], data['intro'], data['star'],
                 data['score'], data['price'], data['SmallsightImgURL'], 1))
            connection.commit()

            print('--- {} 数据已录入 ---'.format(data['sightName']))

    except Exception as e:
        print("save to sql worry!!")
        print(e)
    finally:
        connection.close()

        # print(result)




def requestData(url):
    header = {
        'User-Agent':
        'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_11_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/64.0.3282.186 Safari/537.36',
        'cookie':
        '_i=RBTjeaInT1RQ818x6VRnzkg2BX_x; QN57=15194606642250.8287380340057549; cto_lwid=70964639-7e63-4c7e-a101-a90cab028f33; QN99=4248; QunarGlobal=10.86.213.151_-333dfea0_161e09bb782_-65fb|1519892167944; QN601=e1ac0fbb09327aab7c6839beea72956d; QN48=tc_f78638d6a3eebe2b_161e0a212cd_3a7f; QN1=O5cv5lqX3ltQpY9DDzuXAg==; QN73=3087-3088; __utmz=183398822.1521079863.13.3.utmcsr=hotel.qunar.com|utmccn=(referral)|utmcmd=referral|utmcct=/; Qs_lvt_55613=1521027097%2C1521080296%2C1521109509%2C1521169738%2C1521199829; Qs_pv_55613=1218768077151019500%2C751241521191590800%2C3876112245866533000%2C3406416473725596700%2C4417262540621707000; Hm_lvt_8fa710fe238aadb83847578e333d4309=1521017092,1521092575,1521181224,1521202569; QN300=organic; QN269=9CF8D2C1BE1611E781D4FA163E7BCC04; __utma=183398822.1406903920.1520047326.1521202570.1524593154.25; QN205=s%3Dgoogle; QN277=s%3Dgoogle; csrfToken=ErW6lxD1JpH5ZusCtaJiIEp5G4mvyd6i; QN163=0; Hm_lvt_75154a8409c0f82ecd97d538ff0ab3f3=1525019330; QN71=MTEzLjEwNS4xMjguMjUwOuW5v+S4nDox; Hm_lvt_15577700f8ecddb1a927813c81166ade=1524593159,1525019336; QN63=%E5%8E%A6%E9%97%A8%7C%E4%B8%AD%E5%9B%BD; QN67=463521%2C215910%2C16050%2C14414%2C12051%2C192051%2C457472; _vi=iXlZj1ohvmuQgErzSpviPDjzzVT67NdPQ8vrrk33iijNwKvXc1hc6_uKr8nbNNKNw69AXuAX37aKAGcZyKbXyeFbYFhmUV73DwdHsTTc7gasL5j89ubVLfBIRyUqA6otYP4wWhAxs4nYhdyYAy39Le0sTeV77tqXD1l4xB1wP9fp; Hm_lpvt_75154a8409c0f82ecd97d538ff0ab3f3=1525020827; QN58=1525019335423%7C1525020895003%7C13; Hm_lpvt_15577700f8ecddb1a927813c81166ade=1525020895; JSESSIONID=F8F13E359495EB9B10E79454EF4CE4CE; Request-Node=d91e13b8f8f03f1285d33bc904401fc7'
    }
    response = requests.get(url, headers=header)
    # json结构转换为字典
    data = json.loads(response.text)
    data = data['data']
    res = data['sightList']

    for i in res:
        sciece_dict = {}
        sciece_dict['sightId'] = str(i['sightId'])
        sciece_dict['sightName'] = i['sightName']
        # sciece_dict['address'] = i['address']
        sciece_dict['point'] = i['point']
        sciece_dict['districts'] = i['districts']
        # sciece_dict['intro'] = i['intro']
        sciece_dict['score'] = i['score']
        sciece_dict['SmallsightImgURL'] = i['sightImgURL']

        try:
            if i['star']:
                sciece_dict['star'] = i['star']
        except:
            sciece_dict['star'] = ''

        try:
            if i['intro']:
                sciece_dict['intro'] = i['intro']
        except:
            sciece_dict['intro'] = ''

        try:
            if i['qunarPrice']:
                sciece_dict['price'] = i['qunarPrice']
        except:
            sciece_dict['price'] = ''

        try:
            if i['address']:
                sciece_dict['address'] = i['address']
        except:
            sciece_dict['address'] = ''

        yield sciece_dict



def main():
    base_url = "http://piao.qunar.com/ticket/list.json?keyword=%E5%8E%A6%E9%97%A8&region=null&from=mps_search_suggest&page="
    for i in range(23,28):
        url = base_url+str(i)
        res = requestData(url)
        for j in res:
            save2sql(**j)
        print('--- page {} done. ---'.format(i))
        time.sleep(3)



    # url = "http://piao.qunar.com/ticket/list.json?keyword=%E5%8E%A6%E9%97%A8&region=null&from=mps_search_suggest&page=1"
    # res = requestData(url)
    # for i in res:
    #     save2sql(**i)




if __name__ == '__main__':
    main()
