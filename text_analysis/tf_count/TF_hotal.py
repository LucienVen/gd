#!/usr/bin/env python3
# -*- coding:utf-8 -*-

# 酒店评论词频统计（已完成数据预处理，直接统计词频）

# 存入已计数的词语
temp = []
# TF 统计
count = {}


for file_name in ['2000_neg_cut_stopword.txt','2000_pos_cut_stopword.txt']:
    # print(file_name)
    with open(file_name, 'r') as f:
        for seq in f.readlines():
            # 去除句子后换行符
            seq = seq.strip()
            # 把句子以空格分开
            seq_list = seq.split(' ')
            if seq_list != ['']:
                # 遍历
                for word in seq_list:
                    # 判断是否已收录
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
    with open('./result/tf_count.txt', 'a') as f:
        f.write(res)


print('--- done. ---')