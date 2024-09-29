<?php

spl_autoload_register(function (string $className) {
    $path = str_replace("InventoryManagement", "src", $className) . ".php";
    $path = __DIR__ . "\\..\\" . $path;
    $path = str_replace("\\", DIRECTORY_SEPARATOR, $path);
    if(file_exists($path)) {
        require_once $path;
    }
});

session_set_cookie_params([
    'lifetime' => 0,
    'path' => '/',
    'domain' => '',
    'secure' => true,
    'httponly' => true,
    'samesite' => 'Strict'
]);
session_start();
session_regenerate_id();
if(!isset($_SESSION["userId"])) {
    $_SESSION["userId"] = null;
}

$routes = require_once __DIR__ . "/../config/routes.php";

$pathInfo = $_SERVER["PATH_INFO"] ?? "/";
$httpMethod = $_SERVER["REQUEST_METHOD"];
$key = "$httpMethod|$pathInfo";

if(array_key_exists($key, $routes)) {
    $staticFunction = $routes[$key];
    if(is_callable($staticFunction)) {
        call_user_func($staticFunction);
    }
}
else {
    http_response_code(404);
    echo "404 NOT FOUND<br>$key";
}
