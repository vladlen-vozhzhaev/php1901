<?php

class Route{
    /*
     * $uri - uri который используется для сравнения с запрошенным uri пользователя($requestURI)
     * $callback - это функция которая должна выполниться, если $uri и $requestURI пользователя совпали
     * Пользователь пришел на страницу http://localhost/login
     * $requestURI = '/login'
     * ДОПУСТИМ в функцию мы передали $uri = "/reg";
     * В результате функция не должна ничего делать, так как uri не совпали
     * А если $uri = '/login', то мы вызываем $callback();
     * */


    public static function get($uri, $callback){
        if($_SERVER['REQUEST_METHOD'] != "GET") return;
        $requestURI = $_SERVER['REQUEST_URI'];
        if($requestURI == $uri){
            exit($callback());
        }
    }

    public static function post($uri, $callback){
        if($_SERVER['REQUEST_METHOD'] != "POST") return;
        $requestURI = $_SERVER['REQUEST_URI'];
        if($requestURI == $uri){
            exit($callback());
        }
    }

    public static function view($uri, $viewPath){
        if($_SERVER['REQUEST_METHOD'] != "GET") return;
        $requestURI = $_SERVER['REQUEST_URI'];
        if(strripos($uri, "{")){
            $path = explode("/", $requestURI);
            if(count($path)<3) return;
            $uri = str_replace("{id}", $path[2], $uri);
        }
        if($requestURI == $uri){
            $content =  file_get_contents($viewPath);
            require_once('template.php');
            exit();
        }
    }
}