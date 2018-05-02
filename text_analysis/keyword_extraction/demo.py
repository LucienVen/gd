#!/usr/bin/env python3
# -*- coding:utf-8 -*-

# bit = b'\xe6\x88\x90\xe5\x8a\x9f'

# print(str(bit, encoding='utf-8'))

import csv
with open('./result/all.csv') as f:
    f_csv = csv.reader(f)
    headers = next(f_csv)
    for row in f_csv:
        print(row[2])