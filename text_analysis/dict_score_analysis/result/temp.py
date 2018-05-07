#!/usr/bin/env python3
# -*- coding:utf-8 -*-

# 构造echart数据可视化结构

# 取值
# 去0
# 排序
# （与index）组成数据

pos_score = []
with open('./test_score.txt', 'r') as f:
    for i in f.readlines():
        if i.strip() != '0' or i.strip() != '':
            lst = i.strip().split(' ')
            # print(lst[0])
            if len(lst) == 2:
                pos_score.append(lst[0])


# print(pos_score)
print('---------')
sorted_score = sorted(pos_score)

res = []
tt = 0
for i in sorted_score:
    if float(i) > 50.0 or float(i) < -50:
        pass
    else:
        res.append([float(tt), float(i)])
        tt += 1

print(res)
    
