<?php

class IndexController extends ControllerBase
{

    public function indexAction()
    {
        echo '<h1>Hello World!</h1>';
    }

    public function testAction()
    {
        if (!$this->redis || !$this->redis->ping()) {
            die('Redis server is not running!');
        }
        $a = $this->redis->get('name');
        var_dump($a);
    }
}