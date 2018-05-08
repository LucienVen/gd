<?php

namespace app\pathplan\validate;

use think\Validate;

class PathplanStepDetail extends Validate
{
    protected $rule = [
          'start' => 'require|max:32|regex:[1-9]\d*\.\d+,[1-9]\d*\.\d+',
          'end' => 'require|max:32|regex:[1-9]\d*\.\d+,[1-9]\d*\.\d+',
          'start_des' => 'require|number',
          'end_des' => 'require|number',
          'distance' => 'require|max:32|regex:[1-9]\d*\.\d+'
      ];

    // protected $scene = [];
}
