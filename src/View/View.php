<?php

namespace InventoryManagement\View;

use InventoryManagement\Controller\ItemController;

class View {
    /* Common */
    private const HTML_START = __DIR__ . "/../templates/common/start.html";
    private const HTML_END = __DIR__ . "/../templates/common/end.html";

    /* Before Login */
    private const HTML_BEFORE_LOGIN_START = __DIR__ . "/../templates/beforeLogin/mainStart.html";
    private const HTML_BEFORE_LOGIN_END = __DIR__ . "/../templates/beforeLogin/mainEnd.html";
    private const HTML_LOGIN = __DIR__ . "/../templates/beforeLogin/login.html";
    private const HTML_SIGNUP = __DIR__ . "/../templates/beforeLogin/signup.html";

    /* After Login */
    private const HTML_HEADER = __DIR__ . "/../templates/afterLogin/header.html";
    private const HTML_AFTER_LOGIN_START = __DIR__ . "/../templates/afterLogin/mainStart.html";
    private const HTML_AFTER_LOGIN_END = __DIR__ . "/../templates/afterLogin/mainEnd.html";
    private const HTML_TABLE = __DIR__ . "/../templates/afterLogin/table.html";

    /* After Login User Related */
    private const HTML_CHANGE_EMAIL = __DIR__ . "/../templates/afterLogin/userRelated/changeEmail.html";
    private const HTML_CHANGE_PASSWORD = __DIR__ . "/../templates/afterLogin/userRelated/changePassword.html";
    private const HTML_DELETE_PROFILE = __DIR__ . "/../templates/afterLogin/userRelated/deleteProfile.html";

    /* After Login Item Related */
    private const HTML_ADD_ITEM = __DIR__ . "/../templates/afterLogin/itemRelated/addItem.html";
    private const PHP_EDIT_ITEM = __DIR__ . "/../templates/afterLogin/itemRelated/editItem.php";

    public static function load(): void {
        $body = file_get_contents(self::HTML_START);
        if($_SESSION["userId"] > 0) {
            $body .= file_get_contents(self::HTML_HEADER);
            $body .= file_get_contents(self::HTML_AFTER_LOGIN_START);
            $body .= file_get_contents(self::HTML_TABLE);
            $body .= file_get_contents(self::HTML_AFTER_LOGIN_END);
        }
        else {
            $body .= file_get_contents(self::HTML_BEFORE_LOGIN_START);
            $body .= file_get_contents(self::HTML_LOGIN);
            $body .= file_get_contents(self::HTML_BEFORE_LOGIN_END);
        }
        $body .= file_get_contents(self::HTML_END);
        echo $body;
        exit();
    }

    public static function templateLogin(): void {
        echo file_get_contents(self::HTML_LOGIN);
        exit();
    }

    public static function templateSignup(): void {
        echo file_get_contents(self::HTML_SIGNUP);
        exit();
    }

    public static function templateChangeEmail(): void {
        if($_SESSION["userId"] > 0) {
            echo file_get_contents(self::HTML_CHANGE_EMAIL);
        }
        else {
            http_response_code(401);
            header("HX-Redirect: /");
        }
        exit();
    }

    public static function templateChangePassword(): void {
        if($_SESSION["userId"] > 0) {
            echo file_get_contents(self::HTML_CHANGE_PASSWORD);
        }
        else {
            http_response_code(401);
            header("HX-Redirect: /");
        }
        exit();
    }

    public static function templateDeleteProfile(): void {
        if($_SESSION["userId"] > 0) {
            echo file_get_contents(self::HTML_DELETE_PROFILE);
        }
        else {
            http_response_code(401);
            header("HX-Redirect: /");
        }
        exit();
    }

    public static function templateTable(): void {
        if($_SESSION["userId"] > 0) {
            echo file_get_contents(self::HTML_TABLE);
        }
        else {
            http_response_code(401);
            header("HX-Redirect: /");
        }
        exit();
    }

    public static function templateAddItem(): void {
        if($_SESSION["userId"] > 0) {
            echo file_get_contents(self::HTML_ADD_ITEM);
        }
        else {
            http_response_code(401);
            header("HX-Redirect: /");
        }
        exit();
    }

    public static function templateEditItem(): void {
        if($_SESSION["userId"] > 0) {
            $item = ItemController::readOne();
            ob_start();
            require_once self::PHP_EDIT_ITEM;
            echo ob_get_clean();
        }
        else {
            http_response_code(401);
            header("HX-Redirect: /");
        }
        exit();
    }
}
