<?php

namespace app\destination\controller;

use think\Request;
use think\Db;
use app\destination\model\Destination as DesModel;

class Destination extends Base
{
    public function heatMap(Request $request)
    {
        // get all province info
        $province = Db::table('qunar')->field('province as name')->distinct(true)->select();

        // Db::table('qunar')->where('province', $p)->();
        for ($i=0; $i < count($province); $i++) {
            $sale_count[$i] = Db::query('select sum(sale_count) as value from qunar where province=?', array($province[$i]['name']))[0];
        }

        for ($i=0; $i < count($province); $i++) {
            $data[$i] = array_merge($province[$i], $sale_count[$i]);
        }

        return $this->sendSuccess($data);
    }
}
