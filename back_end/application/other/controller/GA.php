<?php
/**
 * 遗传算法类
 * Time:    2018-05-09 15:25:32
 *
 * @author Yven <yvenchang@163.com>
 * @access public
 * @todo
**/

namespace app\other\controller;

use NumPHP\Core\NumArray;
use NumPHP\LinAlg\LinAlg;

class GA
{
    /**
     * 迭代次数
     */
    const MAXAGE = 80;
    /**
     * 种群大小
     */
    const POP_SIZE = 50;
    /**
     * 交叉算子
     */
    const PC = 0.9;
    /**
     * 遗传算子
     */
    const PM = 0.05;
    /**
     * 种群代沟
     */
    const GGAP = 0.9;

    /**
     * 位置向量
     *
     * @var Array
     */
    private $position;
    /**
     * 距离矩阵
     *
     * @var Array
     */
    private $distance;
    /**
     * 总节点数
     *
     * @var Int
     */
    private $pointNum;

    /**
     * 父代
     *
     * @var Array
     */
    private $parent;
    /**
     * 被选中的个体
     *
     * @var Array
     */
    private $selIndv;
    /**
     * 种群中每个个体距离和
     *
     * @var Array
     */
    private $popDistance;
    /**
     * 种群中每个个体的适应度
     *
     * @var Array
     */
    private $popFitness;
    /**
     * 种群中的最优个体
     *
     * @var [type]
     */
    private $bestIndv;

    public function __construct(Array $p)
    {
        $this->pointNum = count($p);
        $this->position = $p;
        $this->initDistance();
        $parent = $this->initPop();
    }

    /**
     * 初始化节点距离矩阵，只计算上三角
     *
     * @return void
     */
    private function initDistance()
    {
        // 初始化
        for ($i=0; $i < $this->pointNum; $i++) {
            for ($j=0; $j < $this->pointNum; $j++) {
                $this->distance[$i][$j] = 0;
            }
        }

        for ($i=0; $i < $this->pointNum; $i++) {
            for ($j=$i; $j < $this->pointNum; $j++) {
                $this->distance[$i][$j] = $this->calcuDistance($this->position[$i], $this->position[$j]);
                $this->distance[$j][$i] = $this->distance[$i][$j];
            }
        }
    }

    /**
     * 计算距离
     *
     * @param Array $aDes
     * @param Array $bDes
     * @return float
     */
    private function calcuDistance($aDes, $bDes)
    {
        // return sqrt(pow((float)$aDes[0]-(float)$bDes[0], 2)+pow((float)$aDes[1]-(float)$bDes[1], 2));
        //将角度转为狐度
        $radLat1 = deg2rad($aDes[1]);
        //deg2rad()函数将角度转换为弧度
        $radLat2 = deg2rad($bDes[1]);
        $radLng1 = deg2rad($aDes[0]);
        $radLng2 = deg2rad($bDes[0]);
        $a = $radLat1 - $radLat2;
        $b = $radLng1 - $radLng2;
        $s = 2*asin(sqrt(pow(sin($a/2),2)+cos($radLat1)*cos($radLat2)*pow(sin($b/2),2)))*6371;
        return round($s, 2);
    }

    /**
     * 初始化种群
     *
     * @return void
     */
    private function initPop()
    {
        for ($i=0; $i < self::POP_SIZE; $i++) {
            $this->parent[$i] = range(1, $this->pointNum);
            shuffle($this->parent[$i]);
        }
    }

    /**
     * 计算种群适应度
     *
     * @return void
     */
    public function fitness()
    {
        // var_dump($this->popDistance);
        for ($i=0; $i < self::POP_SIZE; $i++) {
            $this->popFitness[$i] = 1/$this->popDistance[$i];
        }
    }

    /**
     * 计算种群中每个个体的路程
     *
     * @return void
     */
    public function popDistance()
    {
        for ($i=0; $i < self::POP_SIZE; $i++) {
            $this->popDistance[$i] = $this->indvDistance($this->parent[$i]);
            if ($this->popDistance[$i] == 0) var_dump($this->parent[$i]);
        }
    }

    /**
     * 计算个体的路程
     *
     * @return float
     */
    public function indvDistance($indv)
    {
        $tmp = 0;
        for ($k=0; $k < $this->pointNum; $k++) {
            $m = $k==$this->pointNum-1?0:$k+1;
            $tmp += $this->distance[$indv[$k]-1][$indv[$m]-1];
        }
        return $tmp;
    }

    public function select()
    {
        $selNum = max(floor(self::GGAP*self::POP_SIZE+0.5), 2);
        $sumfit[0][0] = $this->popFitness[0];
        for ($i=1; $i < self::POP_SIZE; $i++) {
            $sumfit[0][$i] = $this->popFitness[$i] + $sumfit[0][$i-1];
        }

        $traTmp = new NumArray(range(0, $selNum-1));
        $traTmp->add(rand(0,1))->dot($sumfit[0][self::POP_SIZE-1]/$selNum);

        for ($i=1; $i < $selNum; $i++) {
            $sumfit[$i] = $sumfit[0];
        }
        $sumfit = new NumArray($sumfit);
        $sumfit = $sumfit->getTranspose()->getData();
        $traits[0] = $traTmp->getData();
        for ($i=1; $i < self::POP_SIZE; $i++) {
            $traits[$i] = $traits[0];
        }

        for ($i=0; $i < $selNum; $i++) {
            $sumfit[self::POP_SIZE][$i] = 0;
        }
        for ($i=-1; $i < self::POP_SIZE; $i++) {
            for ($j=0; $j < $selNum; $j++) {
                if ($i == self::POP_SIZE-1) {
                    break;
                }
                $m1 = $traits[$i+1][$j]<$sumfit[$i+1][$j]?1:0;
                $si = $i==-1?self::POP_SIZE:$i;
                $m2 = $sumfit[$si][$j]<=$traits[$i+1][$j]?1:0;
                // $m[$i+1][$j] = $m1 & $m2;
                if ($m1 && $m2 == 1) {
                    $newSel[] = $i+1;
                }
            }
        }
        shuffle($newSel);
        for ($i=0; $i < count($newSel); $i++) {
            $this->selIndv[] = $this->parent[$newSel[$i]];
        }
    }

    /**
     * 交叉操作
     *
     * @return void
     */
    public function recombin()
    {
        $selNum = count($this->selIndv);
        for ($i=0; $i < $selNum-$selNum%2; $i+=2) {
            if (self::PC >= rand(0,1)) {
                $r1 = rand(0, $this->pointNum-1);
                $r2 = rand(0, $this->pointNum-1);
                if ($r1 != $r2) {
                    for ($j=min($r1,$r2); $j < max($r1,$r2); $j++) {
                        $tmp1 = $this->selIndv[$i][$j];
                        $tmp2 = $this->selIndv[$i+1][$j];
                        $this->selIndv[$i][$j] = $tmp2;
                        $this->selIndv[$i+1][$j] = $tmp1;
                        for ($x=0; $x < $this->pointNum; $x++) {
                            if ($this->selIndv[$i][$x] == $this->selIndv[$i][$j] && $x != $j)
                            {
                                $this->selIndv[$i][$x] = $tmp1;
                            }
                            if ($this->selIndv[$i+1][$x] == $this->selIndv[$i+1][$j] && $x != $j)
                            {
                                $this->selIndv[$i+1][$x] = $tmp2;
                            }
                        }
                    }
                }
            }
        }
    }

    /**
     * 变异操作
     *
     * @return void
     */
    public function mutate()
    {
        $selNum = count($this->selIndv);
        for ($i=0; $i < $selNum; $i++) {
            if (self::PM >= rand(0,1)) {
                $r1 = rand(0,$this->pointNum-1);
                $r2 = rand(0,$this->pointNum-1);
                $tmp = $this->selIndv[$i][$r1];
                $this->selIndv[$i][$r1] = $this->selIndv[$i][$r2];
                $this->selIndv[$i][$r2] = $tmp;
            }
        }
    }

    /**
     * 进化逆转
     *
     * @return void
     */
    public function reverse()
    {
        $selNum = count($this->selIndv);
        for ($i=0; $i < $selNum; $i++) {
            $tmp = [];
            $back = $this->indvDistance($this->selIndv[$i]);
            $r1 = rand(0,$this->pointNum-1);
            $r2 = rand(0,$this->pointNum-1);
            $m1 = max($r1,$r2);
            $m2 = min($r1,$r2);
            for ($j=$m1,$k=$m2; $j >= $m2; $k++,$j--) {
                $tmp[$k] = $this->selIndv[$i][$j];
            }
            $i1 = $tmp+$this->selIndv[$i];
            $after = $this->indvDistance($i1);
            if ($after < $back) {
                $this->selIndv[$i] = $i1;
            }
        }
    }

    /**
     * 重新插入子代生成父代新种群
     *
     * @return void
     */
    public function reins()
    {
        $selNum = count($this->selIndv);
        $tmp = $this->popDistance;
        asort($tmp);
        $bestInParent = array_keys($tmp);
        for ($i=0,$j=$selNum; $i < self::POP_SIZE-$selNum; $i++,$j++) {
            $this->selIndv[$j] = $this->parent[$bestInParent[$i]];
        }
        $this->parent = $this->selIndv;
    }

    public function getBest()
    {
        asort($this->popDistance);
        list($n) = array_keys($this->popDistance);
        $value = array($n=>$this->popDistance[$n]);
        // var_dump($this->parent[$n]);
        foreach ($this->parent[$n] as $index => $point) {
            $t = $index+1==$this->pointNum?0:$index+1;
            // var_dump($index);
            $path[$index]['start'] = implode(',', $this->position[$point-1]);
            $path[$index]['end'] = implode(',', $this->position[$this->parent[$n][$t]-1]);
            $path[$index]['start_des'] = $point-1;
            $path[$index]['end_des'] = $this->parent[$n][$t]-1;
            $path[$index]['distance'] = $this->distance[$point-1][$this->parent[$n][$t]-1];
        }
        ksort($path);
        $res['realpath'] = $this->parent[$n];
        $res['path'] = $path;
        $res['distance'] = $this->popDistance[$n];

        return $res;
    }

    public function getPop()
    {
        return $this->parent;
    }
}
