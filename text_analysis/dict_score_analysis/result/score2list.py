#!/usr/bin/env python3
# -*- coding:utf-8 -*-



score = []
quchong = []
with open('./test_score.txt', 'r') as f:
    for i in f.readlines():
        # print(i.strip())
        # 去重
        if i.strip() not in quchong:
            quchong.append(i.strip())
            lst = i.strip().split(' ')
            # print(lst)
            score.append(lst[0])

# print(score)

print('---------------')

score = sorted(score)
print(score)

data = []
# 构造数组
tt = 1
for i in score:
    res = [float(tt), float(i)]
    data.append(res)
    tt += 1

# with open('data.txt', 'w') as target:
#     target.write(data)
print(data)
