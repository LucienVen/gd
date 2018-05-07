#!/usr/bin/env python3
# -*- coding:utf-8 -*-

# 厦门景点评论文本信息爬虫

import requests
import pymysql
import os
import json
import time
import random
from pprint import pprint


# 从数据库中获取景点名称及id
def selectSigthId():
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
            sql = "select name, sight_id from qunar_scenic2 where status = 1"
            cursor.execute(sql)
            result = cursor.fetchall()
            return result

    except Exception as e:
        print('select data false!!')
        print(e)
    finally:
        connection.close()

def changeSuccessStatus(sight_id):
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
            sql = "update `qunar_scenic2` SET is_crawl = 1 where sight_id = %s"
            sql2 = "update `qunar_scenic2` SET status = 2 where sight_id = %s"
            cursor.execute(sql, str(sight_id))
            cursor.execute(sql2, str(sight_id))
            connection.commit()


    except Exception as e:
        print('update status false!!')
        print(e)
    finally:
        connection.close()


def changeAbnormalStatus(sight_id):
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
            sql = "update `qunar_scenic2` SET is_crawl = 3 where sight_id = %s"
            sql2 = "update `qunar_scenic2` SET status = 3 where sight_id = %s"
            cursor.execute(sql, str(sight_id))
            cursor.execute(sql2, str(sight_id))
            connection.commit()

    except Exception as e:
        print('update status false!!')
        print(e)
    finally:
        connection.close()


def getCommentCount(sight_id):
    base_url_head = 'http://piao.qunar.com/ticket/detailLight/sightCommentList.json?sightId='
    base_url_tail = '&index=2&page=1&pageSize=10&tagType=0'
    url = base_url_head + sight_id + base_url_tail
    # print(url)
    ua = randomUA()
    header = {
        'User-Agent':
        ua,
        # 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_11_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/64.0.3282.186 Safari/537.36',
        'cookie':
        '_i=RBTjeaInT1RQ818x6VRnzkg2BX_x; QN57=15194606642250.8287380340057549; cto_lwid=70964639-7e63-4c7e-a101-a90cab028f33; QN99=4248; QunarGlobal=10.86.213.151_-333dfea0_161e09bb782_-65fb|1519892167944; QN601=e1ac0fbb09327aab7c6839beea72956d; QN48=tc_f78638d6a3eebe2b_161e0a212cd_3a7f; QN1=O5cv5lqX3ltQpY9DDzuXAg==; QN73=3087-3088; __utmz=183398822.1521079863.13.3.utmcsr=hotel.qunar.com|utmccn=(referral)|utmcmd=referral|utmcct=/; Qs_lvt_55613=1521027097%2C1521080296%2C1521109509%2C1521169738%2C1521199829; Qs_pv_55613=1218768077151019500%2C751241521191590800%2C3876112245866533000%2C3406416473725596700%2C4417262540621707000; Hm_lvt_8fa710fe238aadb83847578e333d4309=1521017092,1521092575,1521181224,1521202569; QN300=organic; QN269=9CF8D2C1BE1611E781D4FA163E7BCC04; __utma=183398822.1406903920.1520047326.1521202570.1524593154.25; QN205=s%3Dgoogle; QN277=s%3Dgoogle; csrfToken=ErW6lxD1JpH5ZusCtaJiIEp5G4mvyd6i; QN163=0; Hm_lvt_75154a8409c0f82ecd97d538ff0ab3f3=1525019330; QN71=MTEzLjEwNS4xMjguMjUwOuW5v+S4nDox; Hm_lvt_15577700f8ecddb1a927813c81166ade=1524593159,1525019336; QN63=%E5%8E%A6%E9%97%A8%7C%E4%B8%AD%E5%9B%BD; Hm_lpvt_75154a8409c0f82ecd97d538ff0ab3f3=1525020827; _vi=EZ-RwXDq1gXlO-x3EtltLpXko-G-SOSeGCl4LV38qEY5HS-eXG4UvBFW5xmsn_2XZlJ3p1Tu81xPV0MMuIFgFA4iPucrwfqxMaEVwrP7dhkNP8r4yx6QZzJQEfPOPhG0rWkNjj8khpv-_rLM73Stl_0Vo1FSHCQoVLk-_guxtojX; QN67=24826%2C455985%2C193500%2C457988%2C16050%2C215259%2C14554%2C460998%2C202032%2C463521; QN58=1525026428159%7C1525028985447%7C10; Hm_lpvt_15577700f8ecddb1a927813c81166ade=1525028986; JSESSIONID=F25D82FD46F6413F0E904E683C01F51D; Request-Node=478dfa43443657da05e66c4f280d8d22'
        # '_i=RBTjeaInT1RQ818x6VRnzkg2BX_x; QN57=15194606642250.8287380340057549; cto_lwid=70964639-7e63-4c7e-a101-a90cab028f33; QN99=4248; QunarGlobal=10.86.213.151_-333dfea0_161e09bb782_-65fb|1519892167944; QN601=e1ac0fbb09327aab7c6839beea72956d; QN48=tc_f78638d6a3eebe2b_161e0a212cd_3a7f; QN1=O5cv5lqX3ltQpY9DDzuXAg==; QN73=3087-3088; __utmz=183398822.1521079863.13.3.utmcsr=hotel.qunar.com|utmccn=(referral)|utmcmd=referral|utmcct=/; Qs_lvt_55613=1521027097%2C1521080296%2C1521109509%2C1521169738%2C1521199829; Qs_pv_55613=1218768077151019500%2C751241521191590800%2C3876112245866533000%2C3406416473725596700%2C4417262540621707000; Hm_lvt_8fa710fe238aadb83847578e333d4309=1521017092,1521092575,1521181224,1521202569; QN300=organic; QN269=9CF8D2C1BE1611E781D4FA163E7BCC04; __utma=183398822.1406903920.1520047326.1521202570.1524593154.25; QN205=s%3Dgoogle; QN277=s%3Dgoogle; csrfToken=ErW6lxD1JpH5ZusCtaJiIEp5G4mvyd6i; QN163=0; Hm_lvt_75154a8409c0f82ecd97d538ff0ab3f3=1525019330; QN71=MTEzLjEwNS4xMjguMjUwOuW5v+S4nDox; Hm_lvt_15577700f8ecddb1a927813c81166ade=1524593159,1525019336; QN63=%E5%8E%A6%E9%97%A8%7C%E4%B8%AD%E5%9B%BD; QN67=463521%2C215910%2C16050%2C14414%2C12051%2C192051%2C457472; _vi=iXlZj1ohvmuQgErzSpviPDjzzVT67NdPQ8vrrk33iijNwKvXc1hc6_uKr8nbNNKNw69AXuAX37aKAGcZyKbXyeFbYFhmUV73DwdHsTTc7gasL5j89ubVLfBIRyUqA6otYP4wWhAxs4nYhdyYAy39Le0sTeV77tqXD1l4xB1wP9fp; Hm_lpvt_75154a8409c0f82ecd97d538ff0ab3f3=1525020827; QN58=1525019335423%7C1525020895003%7C13; Hm_lpvt_15577700f8ecddb1a927813c81166ade=1525020895; JSESSIONID=F8F13E359495EB9B10E79454EF4CE4CE; Request-Node=d91e13b8f8f03f1285d33bc904401fc7'
    }
    try:
        response = requests.get(url, headers=header)

        # json结构转换为字典
        # 获取评论总条数
        data = json.loads(response.text)
        data = data['data']
        commentCount = data['commentCount']
        return commentCount, 1
    except Exception as e:
        print(e)
        return None, 0



def saveTxt(sight_name, seq):
    file_path = './comment/'+ sight_name + '.txt'
    with open(file_path, 'a') as f:
        seq = seq.strip()
        seq = seq.replace('\t', '。')
        seq = seq.replace('\n', '。')
        seq = seq + '\n'
        f.write(seq)


def randomUA():
    USER_AGENT_LIST = [
        "Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; AcooBrowser; .NET CLR 1.1.4322; .NET CLR 2.0.50727)",
        "Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 6.0; Acoo Browser; SLCC1; .NET CLR 2.0.50727; Media Center PC 5.0; .NET CLR 3.0.04506)",
        "Mozilla/4.0 (compatible; MSIE 7.0; AOL 9.5; AOLBuild 4337.35; Windows NT 5.1; .NET CLR 1.1.4322; .NET CLR 2.0.50727)",
        "Mozilla/5.0 (Windows; U; MSIE 9.0; Windows NT 9.0; en-US)",
        "Mozilla/5.0 (compatible; MSIE 9.0; Windows NT 6.1; Win64; x64; Trident/5.0; .NET CLR 3.5.30729; .NET CLR 3.0.30729; .NET CLR 2.0.50727; Media Center PC 6.0)",
        "Mozilla/5.0 (compatible; MSIE 8.0; Windows NT 6.0; Trident/4.0; WOW64; Trident/4.0; SLCC2; .NET CLR 2.0.50727; .NET CLR 3.5.30729; .NET CLR 3.0.30729; .NET CLR 1.0.3705; .NET CLR 1.1.4322)",
        "Mozilla/4.0 (compatible; MSIE 7.0b; Windows NT 5.2; .NET CLR 1.1.4322; .NET CLR 2.0.50727; InfoPath.2; .NET CLR 3.0.04506.30)",
        "Mozilla/5.0 (Windows; U; Windows NT 5.1; zh-CN) AppleWebKit/523.15 (KHTML, like Gecko, Safari/419.3) Arora/0.3 (Change: 287 c9dfb30)",
        "Mozilla/5.0 (X11; U; Linux; en-US) AppleWebKit/527+ (KHTML, like Gecko, Safari/419.3) Arora/0.6",
        "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.2pre) Gecko/20070215 K-Ninja/2.1.1",
        "Mozilla/5.0 (Windows; U; Windows NT 5.1; zh-CN; rv:1.9) Gecko/20080705 Firefox/3.0 Kapiko/3.0",
        "Mozilla/5.0 (X11; Linux i686; U;) Gecko/20070322 Kazehakase/0.4.5",
        "Mozilla/5.0 (X11; U; Linux i686; en-US; rv:1.9.0.8) Gecko Fedora/1.9.0.8-1.fc10 Kazehakase/0.5.6",
        "Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/535.11 (KHTML, like Gecko) Chrome/17.0.963.56 Safari/535.11",
        "Mozilla/5.0 (Macintosh; Intel Mac OS X 10_7_3) AppleWebKit/535.20 (KHTML, like Gecko) Chrome/19.0.1036.7 Safari/535.20",
        "Opera/9.80 (Macintosh; Intel Mac OS X 10.6.8; U; fr) Presto/2.9.168 Version/11.52",
    ]
    return random.choice(USER_AGENT_LIST)



def getCommentTxt(sight_id, sight_name, commentCount):
    ua = randomUA()
    header = {
        'User-Agent': ua,
        # 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_11_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/64.0.3282.186 Safari/537.36',
        'cookie':
        # '_i=RBTjeaInT1RQ818x6VRnzkg2BX_x; QN57=15194606642250.8287380340057549; cto_lwid=70964639-7e63-4c7e-a101-a90cab028f33; QN99=4248; QunarGlobal=10.86.213.151_-333dfea0_161e09bb782_-65fb|1519892167944; QN601=e1ac0fbb09327aab7c6839beea72956d; QN48=tc_f78638d6a3eebe2b_161e0a212cd_3a7f; QN1=O5cv5lqX3ltQpY9DDzuXAg==; QN73=3087-3088; __utmz=183398822.1521079863.13.3.utmcsr=hotel.qunar.com|utmccn=(referral)|utmcmd=referral|utmcct=/; Qs_lvt_55613=1521027097%2C1521080296%2C1521109509%2C1521169738%2C1521199829; Qs_pv_55613=1218768077151019500%2C751241521191590800%2C3876112245866533000%2C3406416473725596700%2C4417262540621707000; Hm_lvt_8fa710fe238aadb83847578e333d4309=1521017092,1521092575,1521181224,1521202569; QN300=organic; QN269=9CF8D2C1BE1611E781D4FA163E7BCC04; __utma=183398822.1406903920.1520047326.1521202570.1524593154.25; QN205=s%3Dgoogle; QN277=s%3Dgoogle; csrfToken=ErW6lxD1JpH5ZusCtaJiIEp5G4mvyd6i; QN163=0; Hm_lvt_75154a8409c0f82ecd97d538ff0ab3f3=1525019330; QN71=MTEzLjEwNS4xMjguMjUwOuW5v+S4nDox; Hm_lvt_15577700f8ecddb1a927813c81166ade=1524593159,1525019336; QN63=%E5%8E%A6%E9%97%A8%7C%E4%B8%AD%E5%9B%BD; QN67=463521%2C215910%2C16050%2C14414%2C12051%2C192051%2C457472; _vi=iXlZj1ohvmuQgErzSpviPDjzzVT67NdPQ8vrrk33iijNwKvXc1hc6_uKr8nbNNKNw69AXuAX37aKAGcZyKbXyeFbYFhmUV73DwdHsTTc7gasL5j89ubVLfBIRyUqA6otYP4wWhAxs4nYhdyYAy39Le0sTeV77tqXD1l4xB1wP9fp; Hm_lpvt_75154a8409c0f82ecd97d538ff0ab3f3=1525020827; QN58=1525019335423%7C1525020895003%7C13; Hm_lpvt_15577700f8ecddb1a927813c81166ade=1525020895; JSESSIONID=F8F13E359495EB9B10E79454EF4CE4CE; Request-Node=d91e13b8f8f03f1285d33bc904401fc7'
        '_i=RBTjeaInT1RQ818x6VRnzkg2BX_x; QN57=15194606642250.8287380340057549; cto_lwid=70964639-7e63-4c7e-a101-a90cab028f33; QN99=4248; QunarGlobal=10.86.213.151_-333dfea0_161e09bb782_-65fb|1519892167944; QN601=e1ac0fbb09327aab7c6839beea72956d; QN48=tc_f78638d6a3eebe2b_161e0a212cd_3a7f; QN1=O5cv5lqX3ltQpY9DDzuXAg==; QN73=3087-3088; __utmz=183398822.1521079863.13.3.utmcsr=hotel.qunar.com|utmccn=(referral)|utmcmd=referral|utmcct=/; Qs_lvt_55613=1521027097%2C1521080296%2C1521109509%2C1521169738%2C1521199829; Qs_pv_55613=1218768077151019500%2C751241521191590800%2C3876112245866533000%2C3406416473725596700%2C4417262540621707000; Hm_lvt_8fa710fe238aadb83847578e333d4309=1521017092,1521092575,1521181224,1521202569; QN300=organic; QN269=9CF8D2C1BE1611E781D4FA163E7BCC04; __utma=183398822.1406903920.1520047326.1521202570.1524593154.25; QN205=s%3Dgoogle; QN277=s%3Dgoogle; csrfToken=ErW6lxD1JpH5ZusCtaJiIEp5G4mvyd6i; QN163=0; Hm_lvt_75154a8409c0f82ecd97d538ff0ab3f3=1525019330; QN71=MTEzLjEwNS4xMjguMjUwOuW5v+S4nDox; Hm_lvt_15577700f8ecddb1a927813c81166ade=1524593159,1525019336; QN63=%E5%8E%A6%E9%97%A8%7C%E4%B8%AD%E5%9B%BD; Hm_lpvt_75154a8409c0f82ecd97d538ff0ab3f3=1525020827; _vi=EZ-RwXDq1gXlO-x3EtltLpXko-G-SOSeGCl4LV38qEY5HS-eXG4UvBFW5xmsn_2XZlJ3p1Tu81xPV0MMuIFgFA4iPucrwfqxMaEVwrP7dhkNP8r4yx6QZzJQEfPOPhG0rWkNjj8khpv-_rLM73Stl_0Vo1FSHCQoVLk-_guxtojX; QN67=24826%2C455985%2C193500%2C457988%2C16050%2C215259%2C14554%2C460998%2C202032%2C463521; QN58=1525026428159%7C1525028985447%7C10; Hm_lpvt_15577700f8ecddb1a927813c81166ade=1525028986; JSESSIONID=F25D82FD46F6413F0E904E683C01F51D; Request-Node=478dfa43443657da05e66c4f280d8d22'
    }

    # base_url_head = 'http://piao.qunar.com/ticket/detailLight/sightCommentList.json?sightId='
    # base_url_tail = '&index=2&page=1&pageSize=10&tagType=0'
    # url = base_url_head + sight_id + base_url_tail

    # response = requests.get(url, headers=header)
    # data = json.loads(response.text)
    # data = data['data']
    # commentList = data['commentList']
    # for content in commentList:
    #     # 写入文本
    #     saveTxt(sight_name, content['content'])

    base_url = 'http://piao.qunar.com/ticket/detailLight/sightCommentList.json'
    # payload = {"sightId": sight_id, }
    # sightId=&index=2&page=1&pageSize=10&tagType=0

    if(int(commentCount) != 0):
        print('--- {} 评论正在写入... ---'.format(sight_name))
        if (int(commentCount) >= 1000):
            temp = int(commentCount) // 1000
            for page in range(1, temp):
                if page >= 15:
                    break
                payload = {
                    "sightId": sight_id,
                    "index": '2',
                    "page": str(page),
                    "pageSize": '1000',
                    "tagType": '0'
                }
                response = requests.get(base_url, headers=header, params=payload)
                # print(response.url)
                data = json.loads(response.text)
                data = data['data']
                commentList = data['commentList']
                for content in commentList:
                    # 写入文本
                    saveTxt(sight_name, content['content'])
                time.sleep(2)
            # 更改状态
            changeSuccessStatus(sight_id)
            print('--- {} 评论已写入完成!! ---'.format(sight_name))
        elif(int(commentCount) < 1000):
            payload = {
                    "sightId": sight_id,
                    "index": '2',
                    "page": '1',
                    "pageSize": str(commentCount),
                    "tagType": '0'
                }
            response = requests.get(base_url, headers=header, params=payload)
            # print(response.url)
            data = json.loads(response.text)
            data = data['data']
            commentList = data['commentList']
            for content in commentList:
                # 写入文本
                saveTxt(sight_name, content['content'])

            # 更改状态
            changeSuccessStatus(sight_id)
            print('--- {} 评论已写入完成!! ---'.format(sight_name))
            time.sleep(3)
    else:
        print('--- {} 无评论 ---'.format(sight_name))




def main():
    sight = selectSigthId()
    for i in sight:
        # print(i['name'], ' => ', i['sight_id'])
        sight_name = i['name']
        sight_id = i['sight_id']
        commentCount, status = getCommentCount(sight_id)
        if status != 0:
            try:
                getCommentTxt(sight_id, sight_name, commentCount)
            except Exception as e:
                print(e)
                changeAbnormalStatus(sight_id)




if __name__ == '__main__':
    main()
    # getCommentCount('1708816601')
    # getCommentTxt('1708816601', 100, '鼓浪屿')