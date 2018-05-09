<?php

namespace app\other\controller;

// use PHPUnit\Framework\TestCase;

class GATest
{
    public function test()
    {
        $ga = new GA([
            [123.232, 222.333],
            [233.121, 313.244],
            [222.122, 123.444],
            [166.232, 156.214],
            [177.344, 166.124],
            // [166.212, 141.156],
            // [136.432, 125.564],
            // [164.652, 245.824],
            // [257.246, 246.231],
            [262.235, 754.131]
        ]);

        $ga->popDistance();
        $ga->fitness();
        $ga->select();
        $ga->recombin();
    }
}
