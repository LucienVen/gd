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
    private $ga;
    private $goOff;
    private $arrival;
    private $playTimeSel;
    private $timeType = [6, 11];
    private $point;
    private $position;
    private $mapping;
    private $startCity;
    private $endCity;

    public function index(Request $request)
    {
        $p = $this->dataProcessing($request->post());
        // var_dump($p);
        foreach ($p as $value) {
            $this->position[$value['id']] = explode(',', $value['position']);
            $this->point[$value['id']] = $value;
        }
        $this->mapping = array_keys($this->position);
        // var_dump($position);
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
        // return $this->sendSuccess($this->ga->getBest());
    }

    private function dataProcessing($data)
    {
        $pointData = [];
        $desModel = new DesModel;
        $desTypeModel = new DesTypeModel;

        if (!isset($data['go_off']) || !isset($data['arrival']) || !isset($data['play_time']) || !isset($data['type_id']) || !isset($data['start_city']) || !isset($data['end_city'])) {
            return $this->sendError(400, "data error", 400);
        }

        $this->goOff = $data['go_off'];
        $this->arrival = $data['arrival'];
        $this->playTimeSel = $data['play_time']-1;
        $this->startCity = $data['start_city'];
        $this->endCity = $data['end_city'];

        if (is_string($data['type_id'])) {
            $type = explode(',', $data['type_id']);
        } elseif (is_array($data['type_id'])) {
            $type = $data['type_id'];
        } else {
            return $this->sendError(400, "data type error!", 400);
        }

        foreach ($type as $value) {
            if (($pid = $desTypeModel->where('id', $value)->value('pid')) != 0) {
                $orCon = ['ds.id', $pid];
            } else {
                $orCon = [];
            }
            $pointData = array_merge($pointData,
                $desModel->where('ds.id', $value)->whereOr($orCon)->alias('ds')
                ->join('destination_detail dd', 'dd.des_id=ds.id')
                ->field('ds.id,dd.position,dd.cost_time,dd.cost_max_time')
                ->select()
            );
        }

        return $pointData;
    }

    private function dateReturn($data)
    {
        $time = explode(',', $this->goOff);
        $tstart = idate('z', strtotime($time[0]));
        $tend = idate('z', strtotime($time[1]));

        $res = [
            'go_off' => $time[0],
            'cost_time' => $tend-$tstart+1
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
                $day[$i]['move_city'] = $this->startCity.','.$this->endCity;
            } elseif ($i == $res['cost_time']-1) {
                $day[$i]['move_city'] = $this->endCity.','.$this->startCity;
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

        // $dayCost = $data['realpath'][0];

        // foreach ($data['realpath'] as $key => $value) {
        //     if ($key == 0) continue;

        //     $nowNodeTime = $this->point[$value]['cost_time'];

        //     // TODO
        //     if ($nowNodeTime >= 24.00) {
        //         $nowNodeTime = 0;
        //     }

        //     if ($this->playTimeSel) {
        //         $dayCost[$key] = $nowNodeTime + $dayCost[$key-1];
        //     } else {
        //         $dayCost[$key] = ($nowNode['cost_max_time']==0?$nowNodeTime:$nowNode['cost_max_time']) + $dayCost[$key-1];
        //     }
        // }

        // do{
        //     $per = ceil(array_pop($dayCost)/$res['cost_time']);
        // }while($per > $this->timeType[$this->playTimeSel]);
        // count($data['realpath']) - count($dayCost)+1;
    }
}
