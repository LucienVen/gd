#!/usr/bin/env python3
# -*- coding:utf-8 -*-

# 去除抽取出来的停用词的词频

with open('./result/manual_selection_scenic_stopword.txt', 'r') as f:
    for i in f.readlines():
        # print(i.strip())
        lst = i.split(' ')
        # print(lst)
        res = lst[0] + '\n'
        with open('./result/my_clear_scenic_score_stopword.txt', 'a') as target:
            target.write(res)


print('--- done. ---')