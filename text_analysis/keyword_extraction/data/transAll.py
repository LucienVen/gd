#!/usr/bin/env python3
# -*- coding:utf-8 -*-

import csv
import os

res = {}



for i in os.listdir('./commentTxt'):
    # print(i)
    txt_name = i.split('.')
    # title = txt_name[0]
    file_path = './commentTxt/'+i
    # print(file_path)
    with open(file_path, 'r') as f:
        temp_list = []
        for seq in f.readlines():
            seq = seq.strip()
            temp_list.append(seq)

        # 拼接成一篇文章
        chap = ''
        for w in temp_list:
            chap = chap + w + '。'

        res[txt_name[0]] = chap


# 构造元组
tup = []
num = 1
for k, v in res.items():
    tt = (num, k, v)
    tup.append(tt)
    num += 1

# print(tup)

# info = []
# temp = 1
# with open('./test.txt', 'r') as f:
#     # 构造元组
#     for i in f.readlines():
#         i = i.strip()
#         # res = (temp, "评论", i)
#         info.append(i)
#         # temp += 1

# seq = ''
# for i in info:
#     seq = seq + i + ','

# # print(seq)
# # print(info)

# res = [('1', "酒店评论", seq)]

headers = ['id', 'title', 'abstract']

with open('stocksAll.csv', 'w') as f:
    f_csv = csv.writer(f)
    f_csv.writerow(headers)
    f_csv.writerows(tup)

print('--- done ---')