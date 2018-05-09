<?php

namespace app\user\validate;

use think\Validate;

class User extends Validate
{
    protected $rule = [
          'email' => 'require|email',
          'username' => 'max:32',
          'password' => 'require',
          'password_confirm' => 'require'
      ];

    protected $scene = [
        'login' => ['email' => 'require|email', 'password' => 'require'],
        'signup' => ['email' => 'require|email|unique:user', 'password' => 'require|min:6|confirm:password_confirm'],
        'update' => ['password' => 'min:6|confirm:password_confirm', 'username' => 'max:32|unique:user'],
    ];
}
