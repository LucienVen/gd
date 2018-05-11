<?php
/**
 * 路线规划类
 * Feature: 路线规划
 * Time:    2018-05-09 15:25:13
 *
 * @author Yven <yvenchang@163.com>
 * @access public
 * @todo
**/

namespace app\other\controller;

use think\Request;
use app\destination\model\DestinationTypes as DesTypeModel;
use app\destination\model\Destination as DesModel;

class Design extends Base
{
    /**
     * 遗传算法计算对象
     *
     * @var GA
     */
    private $ga;

    /**
     * 起始终止时间
     *
     * @var String
     */
    private $goOff;

    /**
     * 总计游玩天数
     *
     * @var Int
     */
    private $total;

    /**
     * 到达时间
     *
     * @var String
     */
    private $arrival;

    /**
     * 游玩时间类型选择
     *
     * @var Int
     */
    private $playTimeSel;

    /**
     * 游玩时间类型大小
     *
     * @var array
     */
    private $timeType = [6, 11];

    /**
     * 选择规划点集合
     *
     * @var Array
     */
    private $point;

    /**
     * 选择规划点坐标集合
     *
     * @var Array
     */
    private $position;

    /**
     * 城市点与景点id映射
     *
     * @var Array
     */
    private $mapping;

    /**
     * 起始点名称
     *
     * @var String
     */
    private $startCity;

    /**
     * 目标点名称
     *
     * @var String
     */
    private $endCity;

    /**
     * 时间格式匹配
     *
     * @var String
     */
    private $timePregMatch = '(20\d{2})-([0|1]\d)-([0|1|2|3]\d)';

    /**
     * 景点模型对象
     *
     * @var DesModel
     */
    private $desModel;
    private $desTypeModel;

    /**
     * 规划接口入口
     *
     * @param Request $request
     * @return Json
     */
    public function index(Request $request)
    {
        $this->desModel = new DesModel;
        $this->desTypeModel = new DesTypeModel;

        if (!$this->dataProcessing($request->post())) {
            return $this->sendError(400, "Data Error!");
        }

        $this->mapping = array_keys($this->position);
        $this->ga = new GA(array_values($this->position));
        for ($i=0; $i < $this->ga::MAXAGE; $i++) {
            $this->ga->popDistance();
            $this->ga->fitness();
            $this->ga->select();
            $this->ga->recombin();
            $this->ga->mutate();
            $this->ga->reverse();
            $this->ga->reins();
        }
        return $this->sendSuccess($this->dateReturn($this->ga->getBest()));
    }

    private function dataProcessing($data)
    {

        if (!isset($data['go_off']) ||
            0 == preg_match('/'.$this->timePregMatch.','.$this->timePregMatch.'/', $data['go_off']) ||
            !isset($data['arrival']) ||
            // 0 == preg_match('/'.$this->timePregMatch.'[0|1|2]\d:[0|1|2|3|4|5]\d'.'/', $data['arrival']) ||
            !isset($data['play_time']) ||
            !isset($data['type_id']) ||
            !isset($data['start_city']) ||
            !isset($data['end_city'])) {
            return false;
        }

        $this->arrival = $data['arrival'];
        $this->playTimeSel = $data['play_time'];
        $this->startCity = $data['start_city'];
        $this->endCity = $data['end_city'];
        $this->goOff = explode(',', $data['go_off']);
        $this->total = idate('z', strtotime($this->goOff[1]))-idate('z', strtotime($this->goOff[0]))+1;

        if (is_string($data['type_id'])) {
            $type = explode(',', $data['type_id']);
        } elseif (is_array($data['type_id'])) {
            $type = $data['type_id'];
        } else {
            return false;
        }

        $point = $this->selPoint($type);

        foreach ($point as $value) {
            $this->position[$value['id']] = explode(',', $value['position']);
            $this->point[$value['id']] = $value;
        }

        return true;
    }

    private function selPoint($type)
    {
        $pointData = [];

        foreach ($type as $value) {
            if (($pid = $this->desTypeModel->where('id', $value)->value('pid')) != 0) {
                $orCon = ['ds.id' => $pid];
            } else {
                $orCon = [];
            }
            $pointData = array_merge($pointData,
                $this->desModel->where('ds.id', $value)->whereOr($orCon)->alias('ds')
                ->join('destination_detail dd', 'dd.des_id=ds.id')
                ->order('dd.score desc')
                ->field('ds.id,dd.position,dd.cost_time,dd.cost_max_time')->select()
            );
        }

        return $pointData;
    }

    private function addPoint(&$point)
    {
        $optionData = $this->desModel->join('destination_detail dd', 'dd.des_id=ds.id')
            ->order('desc dd.score')
            ->field('ds.id,dd.position,dd.cost_time,dd.cost_max_time')
            ->limit(10)->select();
        while (count($point) < $total) {
            array_push($point);
        }
        if ($this->calcTime($point)/$total > $this->timeType[$this->playTimeSel]) {
        }
    }

    private function calcTime($point)
    {
        $totalTime = 0;
        // if ($value['cost_time'] >= $this->timeType[$this->playTimeSel]) {
        // }
        foreach ($point as $key => $value) {
            if ($value['cost_time'] >= 24) {
                $value['cost_time'] = 0;
            }
            if ($this->playTimeSel) {
                $totalTime += $value['cost_time'];
            } else {
                $totalTime += $value['cost_max_time']==0?$value['cost_time']:$value['cost_max_time'];
            }
        }

        return $totalTime;
    }

    private function timePlan()
    {
    }

    private function dateReturn($data)
    {
        // $time = explode(',', $this->goOff);
        // $tstart = idate('z', strtotime($time[0]));
        // $tend = idate('z', strtotime($time[1]));

        $res = [
            'go_off' => $this->goOff[0],
            'cost_time' => $this->total
        ];

        $idx = floor(count($data['realpath'])/$res['cost_time']);
        $rd = [];
        for ($i=0; $i < $res['cost_time']; $i++) {
            if ($i==$res['cost_time']-1) {
                $rd[$i] = (int)count($data['realpath'])-array_sum($rd);
            } else {
                $tmp = [round($idx+rand(0,1)), round($idx-rand(0,1))];
                $rd[$i] = (int)$tmp[array_rand($tmp)];
            }
        }
        shuffle($rd);
        $p = 0;
        $day = [];
        for ($i=0; $i < $res['cost_time']; $i++) {
            $day[$i] = [
                'day_distance' => 0,
                'detail' => []
            ];
            if ($i == 0) {
                $day[$i]['move_city'] = $this->startCity.'->'.$this->endCity;
            } elseif ($i == $res['cost_time']-1) {
                $day[$i]['move_city'] = $this->endCity.'->'.$this->startCity;
            } else {
                $day[$i]['move_city'] = $this->endCity;
            }
            $detail = array_slice($data['path'], $p, $rd[$i]);
            foreach ($detail as $k => $v) {
                $detail[$k]['start_des'] = $this->mapping[$v['start_des']];
                $detail[$k]['end_des'] = $this->mapping[$v['end_des']];
            }
            $day[$i]['detail'] = $detail;
            $day[$i]['node'] = $rd[$i];
            $p += $rd[$i];
            foreach ($day[$i]['detail'] as $key => $value) {
                $day[$i]['day_distance'] += $value['distance'];
            }
        }
        $res['day'] = $day;

        return $res;
    }
}
