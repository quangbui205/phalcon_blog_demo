<?php

use Phalcon\Tag;

class IndexController extends ControllerBase
{
    public function initialize()
    {
        $this->tag->setTitle('Blog Phalcon Demo');
    }

    public function indexAction()
    {
        $this->view->posts = Posts::find();
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