<?php
namespace app\user\model;

use think\Model;

class User extends Model
{
    protected $pk = 'uid';
    protected $readonly = ['email', 'uid', 'root'];
    protected $insert = ['status'=>0, 'is_delete'=>0, 'root'=>1];

    protected function setPasswordAttr($value)
    {
        return password_hash($value, PASSWORD_DEFAULT);
    }
}
