<?php

return [
    "GET|/" => [\InventoryManagement\View\View::class, "load"],
    "GET|/templateLogin" => [\InventoryManagement\View\View::class, "getTemplateLogin"],
    "GET|/templateSignup" => [\InventoryManagement\View\View::class, "getTemplateSignup"],
    "GET|/getEmail" => [\InventoryManagement\Controller\UserController::class, "getEmail"],
    "GET|/templateChangeEmail" => [\InventoryManagement\View\View::class, "getTemplateChangeEmail"],
    "GET|/templateChangePassword" => [\InventoryManagement\View\View::class, "getTemplateChangePassword"],
    "GET|/templateDeleteProfile" => [\InventoryManagement\View\View::class, "getTemplateDeleteProfile"],
    "GET|/templateAddItem" => [\InventoryManagement\View\View::class, "getTemplateAddItem"],
    "GET|/items" => [\InventoryManagement\Controller\ItemController::class, "read"],
    "POST|/login" => [\InventoryManagement\Controller\UserController::class, "login"],
    "POST|/logout" => [\InventoryManagement\Controller\UserController::class, "logout"],
    "POST|/signup" => [\InventoryManagement\Controller\UserController::class, "signup"],
    "POST|/changeEmail" => [\InventoryManagement\Controller\UserController::class, "changeEmail"],
    "POST|/changePassword" => [\InventoryManagement\Controller\UserController::class, "changePassword"],
    "POST|/deleteProfile" => [\InventoryManagement\Controller\UserController::class, "delete"],
    "POST|/addItem" => [\InventoryManagement\Controller\ItemController::class, "create"],
    "POST|/deleteItem" => [\InventoryManagement\Controller\ItemController::class, "delete"],
    "POST|/templateEditItem" => [\InventoryManagement\View\View::class, "getTemplateEditItem"],
    "POST|/editItem" => [\InventoryManagement\Controller\ItemController::class, "update"]
];
