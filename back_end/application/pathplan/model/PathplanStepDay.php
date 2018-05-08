<?php

namespace app\pathplan\model;

use think\Model;

class PathplanStepDay extends Model
{
    public function detail()
    {
        return $this->hasMany('PathplanStepDetail', 'day_id');
    }
}
