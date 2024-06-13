<?php

use vendor\core\Router;

// Получаем строку запроса из глобального массива $_SERVER и убираем слеш в конце, если есть.

echo $query = rtrim($_SERVER['QUERY_STRING'], '/');

define("WWW", __DIR__);
define("ROOT", dirname(__DIR__));
define('CORE', dirname(__DIR__) . '/vendor/core');
define("APP", dirname(__DIR__) . '/app');


// require '../vendor/core/Router.php';
require '../vendor/libs/functions.php';

spl_autoload_register(function ($class) {
    echo $class;
    $file = ROOT . '/' .str_replace('\\','/',$class) . '.php';
    if(is_file($file)){
        require_once ($file);
    }
});

Router::add('pages/?(?P<action>[a-z]+)?$', ['controller' => 'Posts', 'action' => 'index']);
// default routes
Router::add('^$', ['controller' => 'Main', 'action' => 'index']); 
Router::add('^(?P<controller>[a-z]+)/?(?P<action>[a-z]+)?$');

// Выводим отладочную информацию о маршрутах.
// debug(Router::getRoutes());

// Диспетчеризуем маршрут с помощью статического метода dispatch класса Router.
// dispatch - отправка, посылать
Router::dispatch($query);
