<?php

    namespace app\controllers;

    class Posts {

        public function indexAction()
        {
            echo 'PostsNew::index';
        }

        public function testAction()
        {
            echo 'PostsNew::test';
        }

        public function before()
        {
            echo 'PostsNew::before';
        }

    }