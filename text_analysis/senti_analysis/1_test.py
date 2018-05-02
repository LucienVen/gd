#!/usr/bin/env python3
# -*- coding:utf-8 -*-

# 读取所有文件夹文本内容
# 解决了1_process.py 的问题
import os

def getContent(file_path):
    # 设置字符编码集
    decode_set = ['utf-8', 'gb18030', 'gb2312', 'gbk', 'Error']
    for code in decode_set:
        try:
            with open(file_path, 'r', encoding=code) as f:
                res = f.read()
            print('---{}---'.format(file_path))
            return res
        except:
            if code == 'Error':
                # raise Exception("{} can\'t decode".format(file_path))
                print("ignore file: ", file_path)
                return ''





def main():
    base_path = './data/ChnSentiCorp_htl_ba_2000'
    # 获取里面文件夹名字
    names = os.listdir(base_path)

    # print(names)
    for name in names:
        path = base_path + '/' + name
        # ./data/Chn...2000/neg/
        # print(path)
        with open('./result/2000_{}.txt'.format(name), 'a') as f:
            for i in os.listdir(path):
                # print(i)
                file_path = path + '/' + i

                data = getContent(file_path).strip()

                f.write(data)
            # print('len: ', len(os.listdir(path)))



if __name__ == '__main__':
    main()