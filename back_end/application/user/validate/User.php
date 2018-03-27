<?php
namespace app\user\validate;

use think\Validate;

class User extends Validate
{
    // protected $rule = [
        // 'username' => 'require'
    // ];

    protected $scene = [
        'login' => ['username' => 'require|max:32', 'password' => 'require'],
        'signup' => ['username' => 'require|unique:user', 'password' => 'require|min:6']
    ];
}
