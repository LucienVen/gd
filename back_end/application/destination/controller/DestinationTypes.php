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
use app\destination\model\Destination as DesModel;
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
     * Get全部景点类型
     *
     * @param Request $request
     * @return Array
     */
    public function index(Request $request)
    {
        // 初始化
        $cont = $request->get();
        $desModel = new DesModel;

        $page = !isset($cont['page'])?Config::get('condition.page'):(int)$cont['page'];
        $perpage = !isset($cont['perpage'])?Config::get('condition.per_page'):(int)$cont['perpage'];
        $order = !isset($cont['order'])?Config::get('condition.order'):(int)$cont['order'];

        $res = [];
        // 查询
        $res['count'] = $desModel->where('comments', '>', 500)->count();
        // 数据项信息
        $res['page'] = $page;
        $res['per_page'] = $perpage;
        $res['data'] = $desModel->where('d.comments', '>', 500)->alias('d')
                        ->page($page, $perpage)->order('d.comments', $order)
                        ->join('DestinationTypes dt', 'd.type_id=dt.id')
                        ->field('d.type_id,d.comments,dt.name')->select();

        return $this->sendSuccess($res);
    }
}
