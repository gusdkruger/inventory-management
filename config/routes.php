<?php

return [
    "GET|/" => [\InventoryManagement\View\View::class, "load"],
    "POST|/templateLogin" => [\InventoryManagement\View\View::class, "templateLogin"],
    "POST|/login" => [\InventoryManagement\Controller\UserController::class, "login"],
    "POST|/templateSignup" => [\InventoryManagement\View\View::class, "templateSignup"],
    "POST|/signup" => [\InventoryManagement\Controller\UserController::class, "signup"],
    "POST|/getEmail" => [\InventoryManagement\Controller\UserController::class, "getEmail"],
    "POST|/logout" => [\InventoryManagement\Controller\UserController::class, "logout"],
    "POST|/templateChangeEmail" => [\InventoryManagement\View\View::class, "templateChangeEmail"],
    "POST|/changeEmail" => [\InventoryManagement\Controller\UserController::class, "changeEmail"],
    "POST|/templateChangePassword" => [\InventoryManagement\View\View::class, "templateChangePassword"],
    "POST|/changePassword" => [\InventoryManagement\Controller\UserController::class, "changePassword"],
    "POST|/templateDeleteProfile" => [\InventoryManagement\View\View::class, "templateDeleteProfile"],
    "POST|/deleteProfile" => [\InventoryManagement\Controller\UserController::class, "delete"],
    "POST|/templateTable" => [\InventoryManagement\View\View::class, "templateTable"],
    "POST|/items" => [\InventoryManagement\Controller\ItemController::class, "read"],
    "POST|/templateAddItem" => [\InventoryManagement\View\View::class, "templateAddItem"],
    "POST|/addItem" => [\InventoryManagement\Controller\ItemController::class, "add"],
    "POST|/deleteItem" => [\InventoryManagement\Controller\ItemController::class, "delete"],
    "POST|/templateEditItem" => [\InventoryManagement\View\View::class, "templateEditItem"],
    "POST|/editItem" => [\InventoryManagement\Controller\ItemController::class, "update"]
];
