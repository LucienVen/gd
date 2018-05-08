<?php
/**
 * 身份认证
 * Feature: 检测JWT认证身份和验证是否登录
 * TIME:    2018-01-05 13:38:30
 *
 * @author Yven <yvenchang@163.com>
 * @access public
 * @todo
**/

namespace app\user\controller;

use think\Request;
use think\Config;
use think\Cookie;
use Firebase\JWT\JWT;
use app\user\Model\User;

class Auth extends Base
{
    public $apiAuth = false;
    protected $token;
    protected $jwt;

    /**
     * 获取认证
     * @return Json
     */
    public function login(Request $request)
    {
        $data = $request->post();
        $validate = validate('User');

        // 验证数据
        if (!$validate->scene('login')->check($data)) {
            return $this->sendError(400, $validate->getError(), 400);
        }

        $user = new User;
        if ($userData = $user->where(['email'=>$data['email'],'is_delete'=>0,'status'=>0])
                            ->field($this->notField,true)
                            ->find()) {
            if (password_verify($data['password'], $userData['password'])) {
                if ($this->getToken($userData['uid'])->setToken($request)) {
                    unset($userData['password']);
                    return $this->sendSuccess($userData, 'login success!');
                }
            }
        }
        return $this->sendError(400, "user don't exist!", 400);
    }

    /**
     * 退出登录
     *
     * @return Json
     */
    public function logout(Request $request)
    {
        Cookie::set('jwt', '', ['expire' => time()-1, 'httponly' => 'httponly']);
        return $this->sendSuccess('logout success!');
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
                    'exp' => time()+3600*24,
                    'uid' => $uid);

        $this->token = JWT::encode($this->jwt, Config::get('jwt_key'));

        return $this;
    }

    /**
     * 设置 token
     *
     * @return Boolean
     */
    protected function setToken(Request $request)
    {
        if (!is_null($this->token)) {
            Cookie::set('jwt', $this->token, ['expire' => $this->jwt['exp'],'httponly' => 'httponly']);
            return true;
        }
        return false;
    }

}
