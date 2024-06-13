<?php

namespace vendor\core;

class Router {

    protected static $routes = []; // Статическое свойство, хранящее массив маршрутов.
    protected static $route = []; // Статическое свойство, хранящее текущий маршрут.

    // Метод для добавления маршрута в массив маршрутов.
    public static function add($regexp, $route = [])
    {
        self::$routes[$regexp] = $route;
    }

    // Метод для получения всех маршрутов.
    public static function getRoutes() : array
    {
        return self::$routes;
    }

    // Метод для получения текущего маршрута.
    public static function getRoute() : array
    {
        return self::$route;
    }

    // Метод для сопоставления URL с маршрутами.
    private static function matchRoute($url) : bool
    {
        foreach(self::$routes as $pattern => $route) {
            if(preg_match("#$pattern#i", $url, $matches)){ // Используем preg_match для сопоставления URL с шаблоном маршрута.
                // debug($matches); // Выводим отладочную информацию о совпавших подстроках.
                foreach($matches as $key => $value) {
                    if(is_string($key)){
                        $route[$key] = $value;
                    }
                }
                if(!isset($route['action'])) {
                    $route['action'] = 'index';
                }
                $route['controller'] = self::upperCamelCase($route['controller']);
                self::$route = $route; // Устанавливаем текущий маршрут.
                return true; // Если URL совпадает с шаблоном маршрута, возвращаем true.
            }
        }
        return false; // Если ни один из шаблонов маршрута не совпал с URL, возвращаем false.
    }

    // перенаправляет URL по корректному маршруту
    // @param string $url входящий URL
    // return void

    // Метод для обработки маршрута и выполнения соответствующего действия.
    public static function dispatch($url)
    {
        if(self::matchRoute($url)) { // Проверяем совпадение URL с маршрутами.
            $controller = 'app\controllers\\' . self::upperCamelCase(self::$route['controller']);
            // если controller найден в app/controllers
            if(class_exists($controller)) {
                $controllerObj = new $controller(self::$route);
                $action = self::$route['action'] . 'Action';
                if(method_exists($controllerObj, $action)) {
                    $controllerObj -> $action();
                } else {
                    echo 'Method controller action not found';
                }
            } else {
                echo "controller <b>" . $controller . "</b> not found";
            }
        } else {
            http_response_code(404); // Если URL не совпал ни с одним маршрутом, устанавливаем код ответа 404.
            include '404.html'; // Подключаем страницу с сообщением об ошибке 404.
        }
    }

    protected static function upperCamelCase($name)
    {
        return str_replace(' ','', ucwords(str_replace('-',' ', $name)));
    }
}
