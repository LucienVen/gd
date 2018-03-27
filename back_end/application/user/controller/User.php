<?php
// +----------------------------------------------------------------------
// | 用户控制器，用户信息增删查改
// +----------------------------------------------------------------------
// | User: YvenChang |  Email:yvenchang@163.com  | Time:2018/3/21
// +----------------------------------------------------------------------
// | TITLE: 用户接口
// +----------------------------------------------------------------------

namespace app\user\controller;


use think\Request;
use app\user\model\User as UserModel;

/**
 * Class User
 * @title 用户接口
 * @url  http://dawn-api.com/v1/user
 * @desc  用户信息相关接口
 * @version 1.0
 * @readme /doc/md/user.md
 */
class User extends Base
{
    //是否开启授权认证
    public $apiAuth = true;
    //附加方法
    // protected $extraActionList = ['sendCode'];
    //跳过鉴权的方法
    protected $skipAuthActionList = ['sendCode', 'save'];

    /**
     * @title 获取列表
     * @return string name 名字
     * @return string id  id
     * @return integer age  年龄
     * @readme /doc/md/method.md
     */
    public function index(Request $request)
    {
        $user = new UserModel;

        if (($data = $user->where('uid', parent::$app['auth']->token['uid'])->find())) {
            unset($data['password']);
            return $this->sendSuccess($data);
        }

        return $this->sendError(400, 'User dont exsit!', 400);
    }


    /**
     * @title 创建用户
     * @param Request $request
     * @return string name 名字
     * @return string id  id
     * @return object user  用户信息
     * @readme /doc/md/method.md
     * @param  \think\Request $request
     */
    public function save(Request $request)
    {
        $data = $request->post();
        $user = new UserModel;
        $validate = validate('User');

        //  验证
        if (!$validate->scene('signup')->check($data)) {
            return $this->sendError(400, $validate->getError(), 400);
        }
        if ($user->where('username', $data['username'])->find()) {
            return $this->sendError(400, 'Username has exist.', 400);
        }

        //  插入
        if (!$user->allowField(true)->save($data)) {
            return $this->sendError(500, 'Create user fielded, try it again later.', 500);
        }

        return $this->sendSuccess($user->where('uid', $user->uid)->find(), 'Registration success!');
    }

    // /**
    //  * @title 获取单个用户信息
    //  * @param  int $id
    //  * @return string name 名字
    //  * @return string id  id
    //  * @return object user  用户信息
    //  * @readme /doc/md/method.md
    //  * @return \think\Response
    //  */
    // public function read($id)
    // {
    // }

    /**
     * 保存更新的资源
     *
     * @param  \think\Request $request
     * @param  int $id
     * @param  int $id
     * @title 更新用户
     * @return string name 名字
     * @return string id  id
     * @readme /doc/md/method.md
     * @return \think\Response
     */
    public function update(Request $request, $id)
    {
        //
        $testUserData = self::testUserData();
        $data = $testUserData[$id];
        //更新
        $data['age'] = $request->post('age');

        return $this->sendSuccess($data);
    }

    /**
     * 删除指定资源
     *
     * @param  int $id
     * @return object user  用户信息
     * @title 删除用户
     * @return \think\Response
     */
    public function delete($id)
    {
        $testUserData = self::testUserData();

        // delete
        $user = $testUserData[$id];
        unset($testUserData[$id]);
        return $this->sendSuccess(['user' => $user], 'User deleted.');
    }
}
