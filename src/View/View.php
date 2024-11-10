<?php

namespace InventoryManagement\View;

use InventoryManagement\DAO\ItemDAO;

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

    /* After Login User Related */
    private const HTML_CHANGE_EMAIL = __DIR__ . "/../templates/afterLogin/userRelated/changeEmail.html";
    private const HTML_CHANGE_PASSWORD = __DIR__ . "/../templates/afterLogin/userRelated/changePassword.html";
    private const HTML_DELETE_PROFILE = __DIR__ . "/../templates/afterLogin/userRelated/deleteProfile.html";

    /* After Login Item Related */
    /*
    private const HTML_ADD_ITEM = __DIR__ . "/../templates/addItem.html";
    private const HTML_NO_ITEMS = __DIR__ . "/../templates/noItems.html";
    private const HTML_TABLE_HEADER = __DIR__ . "/../templates/tableHeader.html";
    private const PHP_ITEM = __DIR__ . "/../templates/item.php";
    private const PHP_EDIT_ITEM = __DIR__ . "/../templates/editItem.php";
    */

    public static function load(): void {
        $body = file_get_contents(self::HTML_START);
        if($_SESSION["userId"] > 0) {
            $body .= file_get_contents(self::HTML_HEADER);
            $body .= file_get_contents(self::HTML_AFTER_LOGIN_START);
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

    /*
    public static function loadList(array $items): void {
        $body = file_get_contents(self::HTML_TABLE_HEADER);
        if(count($items) === 0) {
            $body .= file_get_contents(self::HTML_NO_ITEMS);
        }
        else {
            foreach($items as $item) {
                ob_start();
                require self::PHP_ITEM;
                $body .= ob_get_clean();
            }
        }
        echo $body;
        exit();
    }
    */

    public static function templateLogin(): void {
        echo file_get_contents(self::HTML_LOGIN);
        exit();
    }

    public static function templateSignup(): void {
        echo file_get_contents(self::HTML_SIGNUP);
        exit();
    }

    public static function templateChangeEmail(): void {
        echo file_get_contents(self::HTML_CHANGE_EMAIL);
        exit();
    }

    public static function templateChangePassword(): void {
        echo file_get_contents(self::HTML_CHANGE_PASSWORD);
        exit();
    }

    public static function templateDeleteProfile(): void {
        echo file_get_contents(self::HTML_DELETE_PROFILE);
        exit();
    }

    /*
    public static function getTemplateAddItem(): void {
        if($_SESSION["userId"] > 0) {
            echo file_get_contents(self::HTML_ADD_ITEM);
        }
        else {
            http_response_code(401);
            header("HX-Redirect: /");
        }
        exit();
    }

    public static function getTemplateEditItem(): void {
        if($_SESSION["userId"] > 0 && isset($_POST["id"])) {
            $item = ItemDAO::readOne($_POST["id"]);
            ob_start();
            require self::PHP_EDIT_ITEM;
            echo ob_get_clean();
        }
        else {
            http_response_code(401);
            header("HX-Redirect: /");
        }
        exit();
    }
    */
}
