#!/usr/bin/env python3
# -*- coding:utf-8 -*-

# 景点评论词频统计
import jieba


# 存入已计数的词语
temp = []
# TF 统计
count = {}

# 去除换行符
# 分词
# 去除停用词

# 停用词保存入数组
stop_word = []
with open('./stopWord.txt', 'r') as f:
    for i in f.readlines():
        i = i.strip()
        stop_word.append(i)


# with open('./result/allScenicTxt.txt', 'r') as f:
with open('./result/allHotalTxt.txt', 'r') as f:

    for seq in f.readlines():
        # 去除换行符
        seq = seq.strip()
        # jieba分词
        seq_cut_list = jieba.cut(seq)
        for word in seq_cut_list:
            # 去除停用词
            if word not in stop_word and word != '':
                # 进行统计
                if word not in temp:
                    temp.append(word)
                    count[word] = 1
                else:
                    count[word] += 1


# 排序
dict_sort = sorted(count.items(), key=lambda item: item[1], reverse=True)
index = 0
# 遍历，打印
for i in dict_sort:
    # 写入文件
    res = str(i[0]) + ' ' + str(i[1]) + '\n'
    with open('./result/tf_my_hotal_count.txt', 'a') as f:
        f.write(res)

print('--- done. ---')