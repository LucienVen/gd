<?php

namespace app\pathplan\validate;

use think\Validate;

class Pathplan extends Validate
{
    protected $rule = [
          'name' => 'require|max:32',
          'cost_time' => 'require|number',
          'cover_url' => 'url'
      ];

    // protected $scene = [];
}
