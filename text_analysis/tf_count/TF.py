#!/usr/bin/env python3
# -*- coding:utf-8 -*-


# 进行词频统计

# 存入已计数的词语
temp = []
# TF 统计
count = {}

# 取出现有停用词
# stopWord = []
# with open('./stopWord.txt', 'r') as f:
#     for i in f.readlines():
#         i = i.strip()
#         stopWord.append(i)


# 先测试pos
with open('./2000_pos_cut.txt', 'r') as f:
    for i in f.readlines():
        words = i.strip()
        for j in words:
            
            if j not in temp:
                count[j] = 1
                temp.append(j)
            else:
                count[j] += 1

# for key in count:
#     res = key + ' ' + str(count[key]) + '\n'
#     with open('./count.txt', 'a') as target:
#         target.write(res)


# 字典排序
num = 0
dict_sort = sorted(count.items(), key=lambda item: item[1], reverse=True)
for ii in dict_sort:
    if ii[1] >= 20:
        # res = ii[0] + ' ' + str(ii[1]) + '\n'
        # with open('./count_more_then_20.txt', 'a') as target:
        #     target.write(res)
        num += 1

print(num)
print('--- done ---')