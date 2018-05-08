<?php

namespace app\pathplan\validate;

use think\Validate;

class PathplanStepDay extends Validate
{
    protected $rule = [
        'day_distance' => 'require|max:32|regex:[1-9]\d*\.\d+',
        'node' => 'require|number',
        'total_time' => 'require|number'
      ];

    // protected $scene = [];
}
