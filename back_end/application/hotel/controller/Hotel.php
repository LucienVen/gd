<?php

namespace app\hotel\controller;

use think\Request;
use think\Config;
use app\hotel\Model\Hotel as HotelModel;

class Hotel extends Base
{
    private $typeMap = ["豪华型","舒适型","客栈民宿","高档型","经济型"];

    public function index(Request $request)
    {
        $cont = $request->get();
        if (!isset($cont['type']) && is_numeric($cont['type'])) {
            return $this->sendError(400, "there isnt field given!");
        }
        $hotelModel = new HotelModel;

        $page = !isset($cont['page'])?Config::get('condition.page'):$cont['page'];
        $perpage = !isset($cont['perpage'])?Config::get('condition.per_page'):$cont['perpage'];

        $res['count'] = $hotelModel->where(['hotel_type' => $this->typeMap[$cont['type']]])->count();
        $res['page'] = $page;
        $res['perpage'] = $perpage;
        $data = $hotelModel->where(['hotel_type' => $this->typeMap[$cont['type']]])
                        ->page($page, $perpage)
                        ->select();

        foreach ($data as $key => $value) {
            $value['impression'] = explode(' ', $value['impression']);
        }

        if (isset($cont['position']) && preg_match('/\d+.\d,\d+.\d/', $cont['position'])) {
            $hotelPos = [];
            $distance = [];
            $pos = explode(',', $cont['position']);
            foreach ($data as $key => $value) {
                $hotelPos = explode(',', $value['point']);
                $distance[$key] = $this->calc($hotelPos, $pos);
            }
            asort($distance);
            $i = 0;
            foreach ($distance as $k => $dis) {
                $newData[$i] = $data[$k];
                $newData[$i++]['distance_from_you'] = $dis;
            }
            $data = $newData;
        }
        $res['data'] = $data;

        return $this->sendSuccess($res);
    }

    private function calc(Array $aDes, Array $bDes)
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
}
