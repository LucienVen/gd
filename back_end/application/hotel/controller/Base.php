<?php
/**
 * 基础类
 * Time:    2018-05-11 01:41:42
 *
 * @author Yven <yvenchang@163.com>
 * @access public
 * @todo
**/

namespace app\hotel\controller;

use DawnApi\facade\ApiController;
class Base extends ApiController
{
    //是否开启授权认证
    public    $apiAuth = false;
}
