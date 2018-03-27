<?php

// +----------------------------------------------------------------------
// | User: YvenChang |  Email:yvenchang@163.com  | Time:2018-03-20
// +----------------------------------------------------------------------
// | TITLE: JWT 身份认证
// +----------------------------------------------------------------------

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
                //  验证时间
                if ($this->token['exp'] < time()) {
                    return false;
                }
                //  验证发放者
                if ($this->token['iss'] != Config::get('iss') || $this->token['aud'] != Config::get('aud')) {
                    return false;
                }
                //  认证通过
                return true;
            }
            // ->certification($request);
        } catch (UnauthorizedException $e) {
            return $e;
        }
    }

    /**
     * 获取客户端信息.
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
     * 获取用户信息.
     *
     * @return mixed
     */
    public function getUser()
    {
    }
}
