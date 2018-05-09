<?php
/**
 * 基础类
 * Time:    2018-05-09 15:24:48
 *
 * @author Yven <yvenchang@163.com>
 * @access public
 * @todo
**/

namespace app\pathplan\controller;


use DawnApi\facade\ApiController;
class Base extends ApiController
{
    //是否开启授权认证
    public    $apiAuth = true;
}
