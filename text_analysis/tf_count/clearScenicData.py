#!/usr/bin/env python3
# -*- coding:utf-8 -*-

# 对景区评论文本去重
# 把去重文件写入同一txt
import os

# 标记句子
temp = []

base_path = './data/commentTxt/'
for file in os.listdir(base_path):
    file_path = base_path+file
    with open(file_path, 'r') as f:
        for seq in f.readlines():
            if seq not in temp:
                temp.append(seq)
                # 文本去重, 并保存到新的文件
                # new_file_path = './cleanScenicData/' + 'new_' + file
                # with open(new_file_path, 'a') as target:
                #     target.write(seq)

                # 把所有文件写入一个文件
                with open('./result/allHotalTxt.txt', 'a') as target:
                    target.write(seq)
        # print(' --- {} 文本去重完成 ---'.format(file))
        print(' --- {} 文本写入完成 ---'.format(file))

print('--- done. ---')
