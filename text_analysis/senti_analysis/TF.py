#!/usr/bin/env python3
# -*- coding:utf-8 -*-

temp = []
count = {}

# 停用词
stopWord = []
with open('./data/stopWord.txt', 'r') as f:
    for i in f.readlines():
        i = i.strip()
        stopWord.append(i)


# 先测试pos
with open('./2000_pos_cut.txt', 'r') as f:
    for i in f.readlines():
        words = i.split()
        # 去除停用词

        for j in words:
            if j not in stopWord:
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