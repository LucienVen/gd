#!/usr/bin/env python3
# -*- coding:utf-8 -*-

# 停用词

stopWord = []

with open('./stopWord.txt', 'r') as f:
    for i in f.readlines():
        i = i.strip()
        stopWord.append(i)


# print(stopWord)
# print(len(stopWord))