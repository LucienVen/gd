<?php
/**
 * 配置文件
 * Time:    2018-05-11 01:38:38
 *
 * @author Yven <yvenchang@163.com>
 * @access public
 * @todo
**/

return [
    'api' => [
        'api_auth' => false,  //是否开启授权认证
        'auth_class' => \app\auth\JWTAuth::class, //授权认证类
        'api_debug'=>false,//是否开启调试
    ]
];
