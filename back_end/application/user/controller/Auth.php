<?php
// +----------------------------------------------------------------------
// | When work is a pleasure, life is a joy!
// +----------------------------------------------------------------------
// | User: ShouKun Liu  |  Email:24147287@qq.com  | Time:2017/3/26 14:24
// +----------------------------------------------------------------------
// | TITLE: this to do?
// +----------------------------------------------------------------------

namespace app\user\controller;

use think\Request;
use think\Config;
use think\Cookie;
use Firebase\JWT\JWT;
use app\user\Model\User;

class Auth extends base
{
    public $apiAuth = false;
    protected $token;
    protected $jwt;

    /**
     * 获取认证
     * @return void
     */
    public function login(Request $request)
    {
        //  重复登录
        if ($request->cookie('jwt')) {
            return $this->sendError(405, 'Has login.', 405);
        }

        $data = $request->post();
        $validate = validate('User');

        // 验证数据
        if (!$validate->scene('login')->check($data)) {
            return $this->sendError(400, $validate->getError(), 400);
        }

        $user = new User;
        if ($userData = $user->where('username', $data['username'])->find()) {
            if (password_verify($data['password'], $userData['password'])) {
                if ($this->getToken($userData['uid'])->setToken()) {
                    unset($userData['password']);
                    return $this->sendSuccess($userData, 'login success!');
                }
            }
        }
        return $this->sendError(400, "user don't exist!", 400);
    }

    /**
     * 获取令牌
     *
     * @param Int $uid
     * @return app\user\Auth
     */
    protected function getToken($uid)
    {
        $this->jwt = array('iss' => Config::get('iss'),
                    'aud' => Config::get('aud'),
                    'exp' => time()+3600*24*7,
                    'uid' => $uid);

        $this->token = JWT::encode($this->jwt, Config::get('jwt_key'));

        return $this;
    }

    /**
     * 设置 token
     *
     * @return Boolean
     */
    protected function setToken()
    {
        if (!is_null($this->token)) {
            Cookie::set('jwt', $this->token, ['expire' => $this->jwt['exp'], 'httponly' => 'httponly']);
            return true;
        }
        return false;
    }

}
