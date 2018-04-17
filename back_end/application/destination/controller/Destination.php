<?php

namespace app\destination\controller;

use think\Request;
use think\Db;
use app\destination\model\Destination as DesModel;

class Destination extends Base
{
    public function heatMap(Request $request)
    {
        // Db::query('select id,location,sale_count from qunar');
        // $data = Db::table('qunar')->limit(100)->field('id, location, sale_count')->select();

        // get all province info
        $province = Db::table('qunar')->field('province')->distinct(true)->select();

        // Db::table('qunar')->where('province', $p)->();
        for ($i=0; $i < count($province); $i++) {
            $sale_count[$i] = Db::query('select sum(sale_count) as count from qunar where province=?', array($province[$i]['province']))[0];
        }

        for ($i=0; $i < count($province); $i++) {
            $data[$i] = array_merge($province[$i], $sale_count[$i]);
        }
        var_dump($data);


    }
}
