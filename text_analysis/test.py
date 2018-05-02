#!/usr/bin/env python3
# -*- coding:utf-8 -*-

with open('./result.txt', 'r') as f:
    for i in f.readlines():
        res = i.strip().replace('-', ' ')
        with open('./res.txt', 'a') as ff:
            ff.write(res+'\n')


