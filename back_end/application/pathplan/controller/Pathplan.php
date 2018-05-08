<?php

namespace app\pathplan\controller;

use think\Request;
use think\Db;
use think\Config;
use app\pathplan\model\Pathplan as PlanModel;
use app\pathplan\model\PathplanStepDay as PlanDayModel;
use app\destination\model\Destination as DesModel;

class Pathplan extends Base
{
    //跳过鉴权的方法
    protected $skipAuthActionList = ['index', 'read'];
    /**
     * 获取用户所有路线
     *
     * @param Request $request
     * @return Json
     */
    public function index(Request $request)
    {
    }

    /**
     * 获取某个路线详情
     *
     * @param Int $id
     * @return Json
     */
    public function read($id)
    {
        // 检查数据格式
        if (!is_numeric($id)) {
            return $this->sendError(400, "Error!");
        }

        $desModel = new DesModel;
        // 获取主数据
        $planModel = PlanModel::get(function($query) use ($id){
            $query->where(['id' => $id])->field('status,create_time,update_time,is_delete',true);
        });
        if (is_null($planModel)) {
            return $this->sendError(400, 'Dont exitis this info!');
        }

        // 获取索引数据
        $day = $planModel->day()->field('create_time,update_time',true)->select();
        // 获取索引对象并查询详情数据
        foreach ($day as $key => $planDayModel) {
            $detail = $planDayModel->detail()->field('create_time,update_time',true)->select();
            foreach ($detail as $dk => $planDetailModel) {
                // 获取景点名称
                $detail[$dk]['start_name'] = $desModel->where(['id'=>$planDetailModel['start_des']])->value('name');
                $detail[$dk]['end_name'] = $desModel->where(['id'=>$planDetailModel['end_des']])->value('name');
            }
            $day[$key]['detail'] = $detail;
        }
        $data = $planModel->toArray();
        $data['day'] = $day;

        return $this->sendSuccess($data);
    }

    /**
     * 存储新的路线
     *
     * @param Request $request
     * @return Json
     */
    public function save(Request $request)
    {
        $data = $request->post();
        $planVa = validate('Pathplan');
        $planDayVa = validate('PathplanStepDay');
        $planDetVa = validate('PathplanStepDetail');
        $totalDetail = [];

        // 主表数据
        $day = $data['day'];
        $pathplan = $data;
        $pathplan['uid'] = parent::$app['auth']->token['uid'];
        unset($pathplan['day']);

        //  验证
        if (!$planVa->check($pathplan)){
            return $this->sendError(400, $planVa->getError(), 400);
        }
        // 数量不一致，数据错误
        if (count($day) != $pathplan['cost_time']) {
            return $this->sendError(400, "Error!");
        }

        foreach ($day as $key => $value) {
            if (!$planDayVa->check($value)) {
                return $this->sendError(400, $planDayVa->getError(), 400);
            }
            // 数量不一致，数据错误
            if (count($value['detail']) != $value['node']) {
                return $this->sendError(400, "Error!");
            }
            $det = $value['detail'];
            // 日程索引表数据
            $day[$key]['day_index'] = $key+1;
            unset($day[$key]['detail']);

            foreach ($det as $k => $detail) {
                if (!$planDetVa->check($detail)) {
                    return $this->sendError(400, $planDetVa->getError());
                }
                // 路程详情表数据
                $det[$k]['index'] = $k+1;
            }
            $totalDetail[$key] = $det;
        }

        // 执行存储
        Db::transaction(function() use ($pathplan, $day, $totalDetail) {
            $pm = new PlanModel;
            $pm->save($pathplan);
            foreach ($day as $key => $value) {
                $dayModel = $pm->find($pm->id)->day()->save($value);
                $dayModel->detail()->saveAll($totalDetail[$key]);
                unset($dayModel);
            }
        });

        return $this->sendSuccess('save success!');
    }
}
