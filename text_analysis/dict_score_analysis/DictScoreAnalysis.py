#!/usr/bin/env python3
# -*- coding:utf-8 -*-


# 基于情感词典的分值计算

from collections import defaultdict
import os
import re
import jieba
import codecs
import random


def seg_word(sentence):
    """使用jieba对文档分词"""
    seg_list = jieba.cut(sentence)
    seg_result = []
    for w in seg_list:
        seg_result.append(w)
    # 读取停用词文件
    stopwords = set()
    fr = codecs.open('./wordDict/stopworks.txt', 'r', 'utf-8')
    for word in fr:
        stopwords.add(word.strip())
    fr.close()

    # 去除停用词
    # print("分词")
    # print(list(filter(lambda x: x not in stopwords, seg_result)))
    return list(filter(lambda x: x not in stopwords, seg_result))


def classify_words(word_dict):
    """词语分类,找出情感词、否定词、程度副词"""
    # 读取情感字典文件
    sen_file = open(
        './wordDict/BosonNLP_sentiment_score.txt', 'r+', encoding='utf-8')
    # 获取字典文件内容
    sen_list = sen_file.readlines()
    # 创建情感字典
    sen_dict = defaultdict()
    # 读取字典文件每一行内容，将其转换为字典对象，key为情感词，value为对应的分值
    for s in sen_list:
        # 每一行内容根据，分割，索引0是情感词，索引01是情感分值
        sen_dict[s.split(' ')[0]] = s.split(' ')[1]

    # 读取否定词文件
    not_comment_word_file = open(
        './wordDict/neg_comment_dict.txt', 'r+', encoding='utf-8')
    # 由于否定词只有词，没有分值，使用list即可
    not_emotion_word_file = open(
        './wordDict/neg_emotion_dict.txt', 'r+', encoding='utf-8')
    not_word_list = not_comment_word_file.readlines(
    ) + not_comment_word_file.readlines()
    not_comment_word_file.close()
    not_emotion_word_file.close()

    # 读取程度副词文件
    # degree_file = open('./wordDict/degree_words.txt', 'r+', encoding='utf-8')
    # degree_list = degree_file.readlines()
    # degree_dic = defaultdict()
    # 程度副词与情感词处理方式一样，转为程度副词字典对象，key为程度副词，value为对应的程度值
    # for d in degree_list:
    # degree_dic[d.split(',')[0]] = d.split(',')[1]

    degree_list = []
    # with open('./wordDict/degree_words.txt', 'r') as f:
    #     for deg in f:
    #         # 清洗，随机赋值
    #         if deg:
    #             deg = deg.strip() + " " + str(random.uniform(1.0, 2.0))
    #             degree_list.append(deg)

    # 程度词
    with open('wordDict/degree/most.txt', 'r') as f:
        for deg in f:
            if deg:
                deg = deg.strip() + ' ' + str(random.uniform(2.0, 2.5))
                degree_list.append(deg)

    with open('wordDict/degree/more.txt', 'r') as f:
        for deg in f:
            if deg:
                deg = deg.strip() + ' ' + str(random.uniform(1.5, 2.0))
                degree_list.append(deg)

    with open('wordDict/degree/very.txt', 'r') as f:
        for deg in f:
            if deg:
                deg = deg.strip() + ' ' + str(random.uniform(1.0, 1.5))
                degree_list.append(deg)

    with open('wordDict/degree/ish.txt', 'r') as f:
        for deg in f:
            if deg:
                deg = deg.strip() + ' ' + str(random.uniform(0.5, 1.0))
                degree_list.append(deg)

    with open('wordDict/degree/insufficient.txt', 'r') as f:
        for deg in f:
            if deg:
                deg = deg.strip() + ' ' + str(random.uniform(0.0, 0.5))
                degree_list.append(deg)

    degree_dic = defaultdict()
    for d in degree_list:
        degree_dic[d.split(' ')[0]] = d.split(' ')[1]

    # degreeDict = defaultdict()
    # for d in degreeList:
    #     degreeDict[d.split(' ')[0]] = d.split(' ')[1]

    # 分类结果，词语的index作为key,词语的分值作为value，否定词分值设为-1
    sen_word = dict()
    not_word = dict()
    degree_word = dict()

    # 分类
    for word in word_dict.keys():
        if word in sen_dict.keys(
        ) and word not in not_word_list and word not in degree_dic.keys():
            # 找出分词结果中在情感字典中的词
            sen_word[word_dict[word]] = sen_dict[word]
        elif word in not_word_list and word not in degree_dic.keys():
            # 分词结果中在否定词列表中的词
            not_word[word_dict[word]] = -1
        elif word in degree_dic.keys():
            # 分词结果中在程度副词中的词
            degree_word[word_dict[word]] = degree_dic[word]
        else:
            continue

    sen_file.close()
    # degree_file.close()

    # 将分类结果返回

    # print("词语分类：")
    # print("情感词: ", sen_word)
    # print("否定词：", not_word)
    # print("程度词：", degree_word)

    return sen_word, not_word, degree_word


def list_to_dict(word_list):
    """将分词后的列表转为字典，key为单词，value为单词在列表中的索引，索引相当于词语在文档中出现的位置"""
    data = {}
    for x in range(0, len(word_list)):
        data[word_list[x]] = x
    # print("分词列表转换为字典：")
    # print(data)
    return data


def get_init_weight(sen_word, not_word, degree_word):
    # 权重初始化为1
    W = 1
    # 将情感字典的key转为list
    sen_word_index_list = list(sen_word.keys())
    if len(sen_word_index_list) == 0:
        return W
    # 获取第一个情感词的下标，遍历从0到此位置之间的所有词，找出程度词和否定词
    for i in range(0, sen_word_index_list[0]):
        if i in not_word.keys():
            W *= -1
        elif i in degree_word.keys():
            # 更新权重，如果有程度副词，分值乘以程度副词的程度分值
            W *= float(degree_word[i])
    return W


def socre_sentiment(sen_word, not_word, degree_word, seg_result):
    """计算得分"""
    # 权重初始化为1
    W = 1
    score = 0
    # 情感词下标初始化
    sentiment_index = -1
    # 情感词的位置下标集合
    sentiment_index_list = list(sen_word.keys())
    # 遍历分词结果(遍历分词结果是为了定位两个情感词之间的程度副词和否定词)
    for i in range(0, len(seg_result)):
        # 如果是情感词（根据下标是否在情感词分类结果中判断）
        if i in sen_word.keys():
            # 权重*情感词得分
            score += W * float(sen_word[i])
            # 情感词下标加1，获取下一个情感词的位置
            sentiment_index += 1
            if sentiment_index < len(sentiment_index_list) - 1:
                # 判断当前的情感词与下一个情感词之间是否有程度副词或否定词
                for j in range(sentiment_index_list[sentiment_index],
                               sentiment_index_list[sentiment_index + 1]):
                    # 更新权重，如果有否定词，取反
                    if j in not_word.keys():
                        W *= -1
                    elif j in degree_word.keys():
                        # 更新权重，如果有程度副词，分值乘以程度副词的程度分值
                        W *= float(degree_word[j])
        # 定位到下一个情感词
        if sentiment_index < len(sentiment_index_list) - 1:
            i = sentiment_index_list[sentiment_index + 1]
    return score


# 计算得分
def setiment_score(sententce):
    # 1.对文档分词
    seg_list = seg_word(sententce)
    # 2.将分词结果列表转为dic，然后找出情感词、否定词、程度副词
    sen_word, not_word, degree_word = classify_words(list_to_dict(seg_list))

    # print(sen_word)
    # print(not_word)
    # print(degree_word)
    # print('>>>'*10)
    # 3.计算得分
    score = socre_sentiment(sen_word, not_word, degree_word, seg_list)
    return score


# 测试

def saveScoreTxt(score, seq):
    res = str(score) + ' ' + seq + '\n'
    res_txt = './result/test_score.txt'
    with open(res_txt, 'a') as f:
        f.write(res)
    print('--- saved. ---')



def main():
    # print(setiment_score("我今天很高兴也非常开心"))
    # print(setiment_score('就是入住手续太过机械和麻烦'))
    # print(setiment_score("比较舒适，环境不错。价格还行"))
    # print('原句：店位置在中山路里面，靠近巴黎春天，位置黄金，也是因为黄金位置造就了酒店的酒店的性价比过低，不过为了方便也还可以接受。中山路真是厦门的黄金夜市区域，十一期间人挤人，人山人海，一眼望不到边，那感觉，太火爆了。')
    # print(
    #     setiment_score(
    #         '店位置在中山路里面，靠近巴黎春天，位置黄金，也是因为黄金位置造就了酒店的酒店的性价比过低，不过为了方便也还可以接受。中山路真是厦门的黄金夜市区域，十一期间人挤人，人山人海，一眼望不到边，那感觉，太火爆了。'
    #     ))

    with open('./data/text.txt', 'r') as f:
        for i in f:
            score = setiment_score(i.strip())
            saveScoreTxt(score, i.strip())
            # print("原句：", i.strip())
            # print("score: ", score)






if __name__ == '__main__':
    main()