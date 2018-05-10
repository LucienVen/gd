<?php

namespace app\pathplan\model;

use think\Model;

class Pathplan extends Model
{
    protected $insert = ['status'=>0, 'is_delete'=>0];
    protected $readonly = ['id'];

    public function day()
    {
        return $this->hasMany('PathplanStepDay', 'plan_id');
    }
}
