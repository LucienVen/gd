<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

use think\Route;

//首页
Route::any('/',function (){
    return redirect('wiki');
});

// 测试数据
Route::any('/test', function(){
    return json_encode(['name' => 123, 'value' => 'Qwer']);
});

Route::group('v1',function (){
    // Route::any('user/sendCode','demo/User/sendCode');
    Route::post('auth', 'user/Auth/login');
    Route::delete('auth', 'user/Auth/logout');
    Route::resource('user','user/User');
    Route::resource('plan', 'pathplan/Pathplan');
    Route::resource('destination', 'destination/Destination');
    Route::group('destination', function () {
        Route::resource('/types', 'destination/DestinationTypes');
        Route::get('/heatmap', 'destination/Destination/heatMap');
    });
    Route::post('design', 'plan/Design');
    Route::post('train', 'other/Ticket/train');
});

//Oauth
// Route::any('accessToken','demo/auth/accessToken');


// 文档
// \DawnApi\route\DawnRoute::wiki();



return [
    '__pattern__' => [
        'name' => '\w+',
    ],
];


