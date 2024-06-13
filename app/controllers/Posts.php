<?php

    namespace app\controllers;

    use vendor\core\base\Controller;

    class Posts extends Controller{

        public function indexAction()
        {
            echo $this -> route;
            echo 'Posts::index';
        }

        public function testAction()
        {
            echo $this -> route;
            echo 'Posts::test';
        }
    }