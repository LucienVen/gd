<?php
/**
 * 票务查询
 * Feature: 火车票查询
 * Time:    2018-05-09 03:13:55
 *
 * @author Yven <yvenchang@163.com>
 * @access public
 * @todo
**/

namespace app\other\controller;

use think\Request;

class Ticket extends Base
{
    private $py_version = "python3";
    private $train_py = "../../spider/inquire12306/train_ticket.py";
    private $code = 'export LANG=en_US.UTF-8;';

    /**
     * 实时获取车票信息
     *
     * @param Request $request
     * @return Json
     */
    public function train(Request $request)
    {
        $data = $request->post();

        // 匹配日期格式
        $mr = \preg_match('/(20\d{2})-([0|1]\d)-([0|1|2|3]\d)/', $data['time'], $match);
        // 比较日期大小
        if (!$mr || \strtotime($data['time']) < \strtotime(date('Y-m-d'))) {
            return $this->sendError(400, "time format error");
        }
        // 检查参数
        if (!isset($data['start']) || !isset($data['end']) || !isset($data['time'])) {
            return $this->sendError(400, "something lost");
        }

        $search = $data['start'].' '.$data['end'].' '.$data['time'];
        $condition = $this->code.$this->py_version.' '.$this->train_py.' '.$search;
        exec($condition, $res, $var);
        $res = json_decode(str_replace("'",'"', $res[0]), true);

        if (!$var) {
            return $this->sendSuccess($res);
        }else {
            return $this->sendError(500, "something error :(");
        }
    }
}
