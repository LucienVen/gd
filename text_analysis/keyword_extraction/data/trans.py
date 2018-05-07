#!/usr/bin/env python3
# -*- coding:utf-8 -*-

import csv

info = []
temp = 1
with open('./test.txt', 'r') as f:
    # 构造元组
    for i in f.readlines():
        i = i.strip()
        # res = (temp, "评论", i)
        info.append(i)
        # temp += 1

seq = ''
for i in info:
    seq = seq + i + ','

# print(seq)
# print(info)

res = [('1', "酒店评论", seq)]

headers = ['id', 'title', 'abstract']

with open('stocks2.csv', 'w') as f:
    f_csv = csv.writer(f)
    f_csv.writerow(headers)
    f_csv.writerows(res)