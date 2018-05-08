<?php
/**
 * 票务基础类
 * Time:    2018-05-09 03:14:52.
 *
 * @author Yven <yvenchang@163.com>
 *
 * @todo
**/

namespace app\other\controller;

use DawnApi\facade\ApiController;

class Base extends ApiController
{
    //是否开启授权认证
    public $apiAuth = false;
}
