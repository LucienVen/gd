<?php
namespace app\user\model;

use think\Model;

class User extends Model
{
    protected $pk = 'uid';
    protected $readonly = ['username'];

    protected function setPasswordAttr($value)
    {
        return password_hash($value, PASSWORD_DEFAULT);
    }
}