<?php
/**
 * 路线规划类
 * Feature: 路线规划
 * Time:    2018-05-09 15:25:13
 *
 * @author Yven <yvenchang@163.com>
 * @access public
 * @todo
**/

namespace app\other\controller;

use think\Request;

class Design extends Base
{
    private $GA;

    protected function initialize()
    {
        parent::initialize();
        $this->GA = new GA;
    }

    public function index(Request $request)
    {
    }

    private function dataProcessing($data)
    {
    }

    private function design()
    {
    }

    private function dateReturn($data)
    {
    }
}
