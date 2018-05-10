<?php
/**
 * 景点类型类
 * Feature: 查询景点类型信息
 * Time:    2018-05-09 15:23:35
 *
 * @author Yven <yvenchang@163.com>
 * @access public
 * @todo
**/

namespace app\destination\controller;

use think\Request;
use think\Config;
use app\destination\model\DestinationTypes as DesTypeModel;

class DestinationTypes extends Base
{
    /**
     * 排序方式的数字化
     *
     * @var order
     */
    private $order = ['asc', 'desc'];

    /**
     * 初始化查询条件
     *
     * @param Array $param
     * @return Array
     */
    private function initConf($param)
    {
        $condition = Config::get('condition');

        foreach ($param as $key => $value) {
            if (array_key_exists($key, $condition) && !is_null($value)) {
                $condition[$key] = intval($value);
            }
        }

        return $condition;
    }

    /**
     * Get全部景点类型
     *
     * @param Request $request
     * @return Array
     */
    public function index(Request $request)
    {
        // 初始化
        $condition = $this->initConf($request->get());
        $desTypeModel = new DesTypeModel;

        // 查询
        if (($data = $desTypeModel->where('id', '>=', ($condition['page']-1)*$condition['per_page']+1)
                                ->limit($condition['per_page'])
                                ->order('value', $this->order[$condition['order']])
                                ->select())) {
            // 数据项信息
            $data['count'] = $desTypeModel->count();
            $data['page'] = $condition['page'];
            $data['per_page'] = $condition['per_page'];

            return $this->sendSuccess($data);
        }

        return $this->sendError(400, 'User dont exsit!', 400);
    }
}
