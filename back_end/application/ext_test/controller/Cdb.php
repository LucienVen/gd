<?php

namespace app\ext_test\controller;

use think\Db;

class Cdb
{
    public function index()
    {
        /**
         * name-name
         * province
         * city-location市
         * type_id-viewpoint-type二级
         * hot
         * comments-comments_num
         * cover_url-photo-url
         */
        /**
         * position
         * description
         * location-location
         * level-level
         * rank
         * cost_time-play_time
         * open_time-open_time
         * ticket_msg-ticket_msg
         * origin_url-detailed_url
         */
        $data = Db::table('xiamen_viewpoint4')
                        // ->limit(10)
                        ->select();
        $p=Db::table('locations')->where('name','like','福建%')->field('id')->find()['id'];
        $c=Db::table('locations')->where('name','like','厦门%')->field('id')->find()['id'];
        foreach ($data as $key => $value) {
            $des[] = [
                'name'=>$value['name'],
                'province'=>$p,
                'city'=>$c,
                'type_id'=>Db::table('destination_types')
                            ->where('name', 'like', count(explode('/',$value['viewpoint_type']))==1?$value['viewpoint_type']:explode('/',$value['viewpoint_type'])[1])
                            ->column('id')[0],
                'hot'=>0,
                'comments'=>$value['comments_num'],
                'cover_url'=>$value['photo_url'],
                'status'=>1,
                'create_time'=>time(),
                'update_time'=>time(),
                'is_delete'=>0
            ];
            $cal = [
                '天' => 24,
                '小时' => 1,
                '时' => 1,
                '分钟' => 1/60,
                '分' => 1/60
            ];
            $time=0;
            $maxtime=0;
            if ($value['play_time'] != '') {
                preg_match("/天|小时|时|分钟|分/",$value['play_time'],$regs);
                $cost=explode('-',explode('建议',$value['play_time'])[1]);
                $time=round((double)$cost[0]*$cal[$regs[0]],2);
                if (count($cost) != 1) {
                    $maxtime=round((double)$cost[1]*$cal[$regs[0]],2);
                }
            }
            if (count(explode('市',$value['location']))==1) {
                $location = $value['location'];
            }else {
                $location = explode('市',$value['location'])[1];
            }
            $desDetail[] = [
                'des_id'=>$key+1,
                'position'=>Db::table('qunar_scenic2')->where('name', 'like', $value['name'])->field('point')->find()['point'],
                'description'=>Db::table('qunar_scenic2')->where('name', 'like', $value['name'])->field('intro')->find()['intro'],
                'location'=>$location,
                'level'=>$value['level'],
                'rank'=>0,
                'cost_time'=>$time,
                'cost_max_time'=>$maxtime,
                'open_time'=>$value['open_time'],
                'ticket_msg'=>$value['ticket_msg'],
                'origin_url'=>$value['detailed_url'],
                'status'=>1,
                'create_time'=>time(),
                'update_time'=>time(),
                'is_delete'=>0
            ];
        }
        // var_dump($data);
        // var_dump($des);
        // var_dump($desDetail);
        Db::table('destinations')->insertAll($des);
        Db::table('destinations_detail')->insertAll($desDetail);
    }

    public function type()
    {
        $data = Db::table('xiamen_viewpoint4')->field('viewpoint_type')->select();
        $len = count($data);
        $i = 0;
        foreach ($data as $value) {
            $type = explode('/', $value['viewpoint_type']);
            if (false == array_search($type[0], $data)) {
                $data[$i++] = ['name' => $type[0], 'pid' => 0, 'value' => 0];
                if (1 != count($type)) {
                    $data[$len++] = ['name' => $type[1], 'pid' => $i - 1, 'value' => 0];
                }
            }
        }
        // var_dump([['name'=>'yven'],['name'=>'rebecca']]);
        // var_dump(array_values($data));

        Db::table('destination_types')->insertAll(array_values($data));

    }
}
