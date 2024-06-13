<?php

    namespace app\controllers;
    
    use vendor\core\base\Controller;

    class Main extends Controller {

        public function indexAction()
        {
            echo $this -> route;
            echo 'Main::index';
        }

    }