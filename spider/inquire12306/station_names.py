#!/usr/bin/env python3
# -*- coding:utf-8 -*-

# 查询站点及代号

import requests
import re
from pprint import pprint

# https://kyfw.12306.cn/otn/resources/js/framework/station_name.js?station_version=1.9048

# header = {
#     'User-Agent':
#     'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_11_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/64.0.3282.186 Safari/537.36',
#     'Cookie':
#     'JSESSIONID=551E1AC376661C27D31F3B792607B3E4; route=6f50b51faa11b987e576cdb301e545c4; BIGipServerotn=4007067914.64545.0000; _jc_save_fromStation=%u5E7F%u5DDE%2CGZQ; _jc_save_toStation=%u53A6%u95E8%2CXMS; _jc_save_fromDate=2018-03-09; _jc_save_toDate=2018-03-09; _jc_save_wfdc_flag=dc; BIGipServerportal=2949906698.16671.0000'
# }


url = "https://kyfw.12306.cn/otn/resources/js/framework/station_name.js?station_version=1.9048"

response = requests.get(url, verify=False)
# pprint(res.text)
# 匹配获取车站与其对应代号
station = re.findall(u'([\u4e00-\u9fa5]+)\|([A-Z]+)\|', response.text)
# print(station)
station_names = dict(station)
# pprint(station_names, indent=4)
