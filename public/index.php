<?php

use vendor\core\Router;

// Получаем строку запроса из глобального массива $_SERVER и убираем слеш в конце, если есть.

echo $query = rtrim($_SERVER['QUERY_STRING'], '/');

define("WWW", __DIR__);
define("ROOT", dirname(__DIR__));
define('CORE', dirname(__DIR__) . '/vendor/core');
define("APP", dirname(__DIR__) . '/app');


// Подключаем файлы Router.php и functions.php из директории vendor/core иk vendor/libs соответственно.
// require '../vendor/core/Router.php';
require '../vendor/libs/functions.php';

spl_autoload_register(function ($class) {
    echo $class;
    $file = ROOT . '/' .str_replace('\\','./',$class) . '.php';
    if(is_file($file)){
        require_once ($file);
    }
});

Router::add('pages/?(?P<action>[a-z]+)?$', ['controller' => 'Posts', 'action' => 'index']);
// default routes
Router::add('^$', ['controller' => 'Main', 'action' => 'index']); // Главная страница по умолчанию.
// Регулярное выражение для сопоставления URL-адресов с контроллерами и действиями в маршрутизаторе.
// Это названная подмаска, которая соответствует названию контроллера. `(?P<controller>)` задает имя подмаски, в данном случае "controller", а `[a-z]+` соответствует одной или более буквенным символам в нижнем регистре.
// `/?:` Символ `/?` соответствует нулю или одному вхождению символа "/" после названия контроллера.
// Это еще одна названная подмаска, соответствующая действию контроллера. `(?P<action>)` задает имя подмаски, в данном случае "action", а `[a-z]+` соответствует одной или более буквенным символам в нижнем регистре. `?` после всего этого делает это выражение необязательным.
Router::add('^(?P<controller>[a-z]+)/?(?P<action>[a-z]+)?$');


// Выводим отладочную информацию о маршрутах.
// debug(Router::getRoutes());

// Диспетчеризуем маршрут с помощью статического метода dispatch класса Router.
// dispatch - отправка, посылать
Router::dispatch($query);
