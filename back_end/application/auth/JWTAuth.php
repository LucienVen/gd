<?php
/**
 * JWT认证类
 * Feature: 为各模块提供登录验证功能
 * TIME:    2018-01-05 14:21:41
 *
 * @author Yven <yvenchang@163.com>
 * @access public
 * @todo
**/

namespace app\auth;

use DawnApi\contract\AuthContract;
use DawnApi\exception\UnauthorizedException;
use think\Exception;
use think\Request;
use think\Config;
use Firebase\JWT\JWT;

class JWTAuth implements AuthContract
{
    /**
     * 认证令牌
     * @var String
     */
    public $token;

    /**
     * 认证授权通过客户端信息和路由等.
     *
     * @param Request $request
     */
    public function authenticate(Request $request)
    {
        try {
            // 获取认证信息
            if ($this->getClient($request)) {
                //  验证发放者
                if ($this->token['iss'] != Config::get('iss') || $this->token['aud'] != Config::get('aud')) {
                    return false;
                }
                //  认证通过
                return true;
            }
        } catch (\Exception $e) {
            return $e;
        }
    }

    /**
     * 获取客户端JWT信息.
     *
     * @param Request $request
     *
     * @return mixed
     */
    public function getClient(Request $request)
    {
        $jwt = $request->cookie('jwt');
        if (!is_null($jwt)) {
            $this->token = (array)JWT::decode($jwt, Config::get('jwt_key'), array('HS256'));
            return true;
        } else {
            return false;
        }
    }

    /**
     * just implement interface
     *
     * @return mixed
     */
    public function getUser()
    {
    }
}
