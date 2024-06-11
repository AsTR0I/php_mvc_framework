<?php

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
    public static function matchRoute($url) : bool
    {
        foreach(self::$routes as $pattern => $route){
            if(preg_match("#$pattern#i", $url, $matches)){ // Используем preg_match для сопоставления URL с шаблоном маршрута.
                debug($matches); // Выводим отладочную информацию о совпавших подстроках.
                self::$route = $route; // Устанавливаем текущий маршрут.
                return true; // Если URL совпадает с шаблоном маршрута, возвращаем true.
            }
        }
        return false; // Если ни один из шаблонов маршрута не совпал с URL, возвращаем false.
    }

    // Метод для обработки маршрута и выполнения соответствующего действия.
    public static function dispatch($url){
        if(self::matchRoute($url)) { // Проверяем совпадение URL с маршрутами.
            echo 'OK'; // Если совпадение найдено, выводим "OK".
        } else {
            http_response_code(404); // Если URL не совпал ни с одним маршрутом, устанавливаем код ответа 404.
            include '404.html'; // Подключаем страницу с сообщением об ошибке 404.
        }
    }
}
