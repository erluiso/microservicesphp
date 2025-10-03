<?php
    header("Access-Control-Allow-Origin: *"); // Allow CORS (if required)
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

    $url = "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $uri = explode( '/', $uri);

    if(isset($uri[1]) && $uri[1] != 'users' && $uri[1] != 'logs.log' && $uri[1] != 'resetLogs') 
    {
        header("HTTP/1.1 404 Not Found");
        exit();
    }

    define("PROJECT_ROOT_PATH", __DIR__);

    require PROJECT_ROOT_PATH . "/src/Controller/UserController.php";
?>