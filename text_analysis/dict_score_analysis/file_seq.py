#!/usr/bin/env python3
# -*- coding:utf-8 -*- 

import os

for i in os.listdir('./data/neg'):
    # print(i)
    file_path = './data/neg/'+i
    with open(file_path, 'r', encoding='utf-8') as f:
        seq = f.readline()
    
    with open('./data/neg.txt', 'a') as f:
        f.write(seq)

print('----- done. -----')