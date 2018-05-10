<?php

namespace app\ext_test\controller;

use think\Db;

class Cdb2
{
    public function index()
    {
        $data = Db::table('xiamen_viewpoint4')->field('tip,score,detail as description,name')->select();
        // var_dump($data);
        foreach ($data as $value) {
            if ($value['score'] == NULL) $value['score']=0;
            $id = Db::table('pd_destination')->where(['name' => ['like', $value['name']]])->value('id');
            unset($value['name']);
            Db::table('pd_destination_detail')->where('id', $id)->update($value);
        }
    }
}
