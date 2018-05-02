#!/usr/bin/env python3
# -*- coding:utf-8 -*-
from __future__ import print_function, unicode_literals
import json
import requests

KEYWORDS_URL = 'http://api.bosonnlp.com/keywords/analysis'

text = '房间还算干净整洁,服务也可以,以这个价格来说,不错了,建议大家要定有窗户的房间,但是餐厅不够好,有一次吃的蘑菇是酸的,附近没有超市,不太方便,买水果都要走很远,'
params = {'top_k': 10}
data = json.dumps(text)
headers = {'X-Token': 'A_vpqem2.25205.SJlKYFwHT6Ud'}
resp = requests.post(
    KEYWORDS_URL, headers=headers, params=params, data=data.encode('utf-8'))

for weight, word in resp.json():
    print(weight, word)