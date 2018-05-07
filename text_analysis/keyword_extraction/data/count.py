#!/usr/bin/env python3
# -*- coding:utf-8 -*-
import os
count = 0
for i in os.listdir('./commentTxt'):
    # print(i)
    file_path = './commentTxt/'+i
    # print(file_path)
    with open(file_path, 'r') as f:
        for j in f.readlines():
            count += 1

print("count", count)