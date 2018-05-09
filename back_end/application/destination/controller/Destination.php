<?php

namespace app\destination\controller;

use think\Request;
use think\Db;
use think\Config;
use app\destination\model\Destination as DesModel;
use app\destination\model\DestinationTypes as DesTypeModel;

class Destination extends Base
{
    /**
     * join表
     *
     * @var array
     */
    private $join = [['destination_detail desd', 'desd.des_id=des.id']];

    /**
     * 获取热门景点概览信息
     *
     * @param Request $request
     * @return Json
     */
    public function index(Request $request)
    {
        $param = $request->get();
        $desModel = new DesModel;
        // 获取热门景点信息
        if ($param['hot'] == '1') {
            // 查询条件
            $condition = [
                'hot'=>1,
                'is_delete'=>0,
                'status'=>0,
            ];
            // 设置城市信息
            if (isset($param['city'])) {
                $cid = Db::table('pd_locations')->where('name','like',$param['city'].'%')->find()['id'];
                $condition = array_merge(['city'=>$cid], $condition);
            }
            // 分页信息
            $page = !isset($param['page'])?Config::get('condition.page'):$param['page'];
            $perpage = !isset($param['perpage'])?Config::get('condition.per_page'):$param['perpage'];
            // 查询字段
            $field = [
                'des.id','des.name','des.comments','cover_url','impression',
                'desd.description','desd.location','desd.cost_time',
                'desd.cost_max_time','desd.open_time','desd.ticket_msg','desd.level','desd.rank'
            ];
            // 总数
            $num = $desModel->where(['city'=>$cid,'hot'=>1,'is_delete'=>0,'status'=>0])->count();
            $data = $desModel->where($condition)
                            ->alias('des')
                            ->join($this->join)
                            ->page($page,$perpage)
                            ->field($field)
                            ->select();
            $res['data'] = $data;
            $res['count'] = $num;
            $res['page'] = $page;
            $res['perpage'] = $perpage;
            return $this->sendSuccess($res);
        }
    }

    /**
     * 获取单个景点的详细信息
     *
     * @param Int $id
     * @return Json
     */
    public function read($id)
    {
        $desModel = new DesModel;
        $desTypeModel = new DesTypeModel;
        if (is_numeric($id)) {
            $data = $desModel->where(['des.id'=>$id, 'is_delete'=>0, 'status'=>0])
                            ->alias('des')
                            ->join($this->join)
                            ->find();
            $data['type_name'] = $desTypeModel->where(['id' => $data['type_id']])->value('name');
            return $this->sendSuccess($data);
        }
        return $this->sendError(400, 'destination id must be numeric');
    }

    /**
     * 热力图数据
     *
     * @return JSON
     */
    public function heatMap(Request $request)
    {
        // get all province info
        $province = Db::table('qunar')->field('province as name')->distinct(true)->select();

        // Db::table('qunar')->where('province', $p)->();
        for ($i = 0; $i < count($province); ++$i) {
            $sale_count[$i] = Db::query('select sum(sale_count) as value from qunar where province=?', array($province[$i]['name']))[0];
        }

        for ($i = 0; $i < count($province); ++$i) {
            $data[$i] = array_merge($province[$i], $sale_count[$i]);
        }

        return $this->sendSuccess($data);
    }
}
