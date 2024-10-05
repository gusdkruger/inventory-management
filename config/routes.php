<?php

return [
    "GET|/" => [\InventoryManagement\View\View::class, "load"],
    "GET|/templateLogin" => [\InventoryManagement\View\View::class, "getTemplateLogin"],
    "GET|/templateSignup" => [\InventoryManagement\View\View::class, "getTemplateSignup"],
    "POST|/login" => [\InventoryManagement\Controller\UserController::class, "login"],
    "POST|/logout" => [\InventoryManagement\Controller\UserController::class, "logout"],
    "POST|/signup" => [\InventoryManagement\Controller\UserController::class, "signup"],
    "POST|/getEmail" => [\InventoryManagement\Controller\UserController::class, "getEmail"]
];
