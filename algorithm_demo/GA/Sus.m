% 输入:
%FitnV  个体的适应度值
%Nsel   被选择个体的数目
% 输出:
%NewChrIx  被选择个体的索引号
function NewChrIx = Sus(FitnV,Nsel)
[Nind,ans] = size(FitnV);
cumfit = cumsum(FitnV);
% 平均适应度*个体行号=适应度在每行的平均比例
trials = cumfit(Nind) / Nsel * (rand + (0:Nsel-1)');
% 适应度真实累加向量，拓展为Nind*Nsel维矩阵
Mf = cumfit(:, ones(1, Nsel));
% 适应度平均比例向量，拓展为Nsel*Nind维矩阵，转置后能与Mf进行比较操作
Mt = trials(:, ones(1, Nind))';
% 寻找适应度高于该种群每行应有的适应度平均比例的个体
% Mt<Mf：从上向下开始逼近该行最佳个体
% z<=mt：从下向上开始逼近该行最佳个体
% &：确定最佳个体所在行
% 获取其行号
[NewChrIx, ans] = find(Mt < Mf & [ zeros(1, Nsel); Mf(1:Nind-1, :) ] <= Mt);
% 生成随机序列
[ans, shuf] = sort(rand(Nsel, 1));
% 随机化
NewChrIx = NewChrIx(shuf);



