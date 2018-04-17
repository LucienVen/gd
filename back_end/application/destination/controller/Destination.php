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
        $data = Db::table('qunar')->limit(10)->field('id, location, sale_count')->select();
        // var_dump($data);

        for ($i=0; $i < count($data); $i++) {
            explode('·', $data[$i]['location'])[0];
        }
    }
}
