<?php

namespace Api\Routes;


class Route {    

    public static bool $found = false;

    public static function post($url, $callback, $data = [], $isProtected = 0) {
        self::handleRoute('POST', $url, $callback, $data, $isProtected);
    }

    public static function get($url, $callback, $data = [], $isProtected = 0) {
        self::handleRoute('GET', $url, $callback, $data, $isProtected);
    }

    public static function put($url, $callback, $data = [], $isProtected = 0) {
        self::handleRoute('PUT', $url, $callback, $data, $isProtected);
    }

    public static function delete($url, $callback, $data = [], $isProtected = 0) {
        self::handleRoute('DELETE', $url, $callback, $data, $isProtected);
    }

    private static function handleRoute($method, $url, $callback, $data, $isProtected) {

        if($_SERVER['REQUEST_METHOD'] !== $method ) {
            return;
        }

        if(!isset($data) || empty($data)) {
            $data = [];
        }

        $requestedURL = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        $pattern = preg_replace('/\/:([a-zA-Z0-9_]+)/', '/(?P<\1>[a-zA-Z0-9_-]+)', $url);
        $pattern = "@^" . $pattern . "$@D";

        if(preg_match($pattern, $requestedURL, $matches)) {
           
            self::$found = true;

            $params = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);

            $finalData = array_merge($data, $params);

            $class = 'Api\\Controllers\\' . $callback[0];
            $method = $callback[1];

            $controller = new $class($isProtected);
            $controller->$method($finalData);

        } 
    }

}