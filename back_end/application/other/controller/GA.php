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
    const MAXAGE = 300;
    const POP_SIZE = 250;
    const PC = 0.9;
    const PM = 0.05;
    const GGAP = 0.9;

    private $position;
    private $distance;
    private $pointNum;

    private $parent;
    private $child;
    private $selIndv;
    private $popDistance;
    private $popFitness;
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
        return sqrt(pow($aDes[0]-$bDes[0], 2)+pow($aDes[1]-$bDes[1], 2));
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
        }
    }

    /**
     * 计算个体的路程
     *
     * @return void
     */
    public function indvDistance($indv)
    {
        // for ($i=0; $i < self::POP_SIZE; $i++) {
            $tmp = 0;
            for ($j=0; $j < $this->pointNum; $j++) {
                // $indv1 = $this->parent[$i][$j];
                // $indv2 = $this->parent[$i][$j+1];
                $m = $j==$this->pointNum-1?0:$j+1;
                $tmp += $this->distance[$indv[$j]-1][$indv[$m]-1];
            }
            // $this->popDistance[$i] = $tmp;
            return $tmp;
        // }
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
            $back = $this->indvDistance($this->selIndv[$i]);
            $r1 = rand(0,$this->pointNum-1);
            $r2 = rand(0,$this->pointNum-1);
            $m1 = max($r1,$r2);
            $m2 = min($r1,$r2);
            for ($j=$m1,$k=$m2; $j >= $m2; $k++,$j--) {
                $tmp[$k] = $this->selIndv[$j];
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
        asort($this->popDistance);
        $bestInParent = array_keys($this->popDistance);
        for ($i=0,$j=$selNum; $i < self::POP_SIZE-$selNum; $i++,$j++) {
            $this->selIndv[$j] = $this->parent[$bestInParent[$i]];
        }
        $this->parent = $this->selIndv;
    }
}
