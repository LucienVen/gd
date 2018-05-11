<?php

namespace app\pathplan\validate;

use think\Validate;

class PathplanStepDay extends Validate
{
    protected $rule = [
        'day_distance' => 'require|max:32',
        'node' => 'require|number',
        'total_time' => 'number',
        'move_city' => 'require'
      ];

    // protected $scene = [];
}
