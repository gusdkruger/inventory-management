<?php

namespace InventoryManagement\View;

use InventoryManagement\DAO\ItemDAO;

class View {
    private const HTML_START = __DIR__ . "/../teamplates/start.html";
    private const HTML_END = __DIR__ . "/../teamplates/end.html";

    private const HTML_AJAX_START = __DIR__ . "/../teamplates/ajax/ajaxStart.html";
    private const HTML_AJAX_END = __DIR__ . "/../teamplates/ajax/ajaxEnd.html";
    private const HTML_LOGIN = __DIR__ . "/../teamplates/ajax/login.html";
    private const HTML_SIGNUP = __DIR__ . "/../teamplates/ajax/signup.html";

    private const HTML_HEADER = __DIR__ . "/../teamplates/header.html";
    private const HTML_MAIN = __DIR__ . "/../teamplates/main.html";

    private const HTML_OVERLAY = __DIR__ . "/../teamplates/overlay.html";
    private const HTML_BUTTON_CLOSE_OVERLAY = __DIR__ . "/../teamplates/buttonCloseOverlay.html";

    private const HTML_CHANGE_EMAIL = __DIR__ . "/../teamplates/changeEmail.html";
    private const HTML_CHANGE_PASSWORD = __DIR__ . "/../teamplates/changePassword.html";
    private const HTML_DELETE_PROFILE = __DIR__ . "/../teamplates/deleteProfile.html";

    private const HTML_ADD_ITEM = __DIR__ . "/../teamplates/addItem.html";
    private const HTML_NO_ITEMS = __DIR__ . "/../teamplates/noItems.html";
    private const HTML_TABLE_HEADER = __DIR__ . "/../teamplates/tableHeader.html";
    private const PHP_ITEM = __DIR__ . "/../teamplates/item.php";
    private const PHP_EDIT_ITEM = __DIR__ . "/../teamplates/editItem.php";

    public static function load(): void {
        $body = file_get_contents(self::HTML_START);
        if($_SESSION["userId"] > 0) {
            $body .= file_get_contents(self::HTML_OVERLAY);
            $body .= file_get_contents(self::HTML_HEADER);
            $body .= file_get_contents(self::HTML_MAIN);
        }
        else {
            $body .= file_get_contents(self::HTML_AJAX_START);
            $body .= file_get_contents(self::HTML_LOGIN);
            $body .= file_get_contents(self::HTML_AJAX_END);
        }
        $body .= file_get_contents(self::HTML_END);
        echo $body;
        exit();
    }

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

    public static function templateLogin(): void {
        echo file_get_contents(self::HTML_LOGIN);
        exit();
    }

    public static function templateSignup(): void {
        echo file_get_contents(self::HTML_SIGNUP);
        exit();
    }

    public static function getTemplateChangeEmail(): void {
        $body = file_get_contents(self::HTML_BUTTON_CLOSE_OVERLAY);
        $body .= file_get_contents(self::HTML_CHANGE_EMAIL);
        echo $body;
        exit();
    }

    public static function getTemplateChangePassword(): void {
        $body = file_get_contents(self::HTML_BUTTON_CLOSE_OVERLAY);
        $body .= file_get_contents(self::HTML_CHANGE_PASSWORD);
        echo $body;
        exit();
    }

    public static function getTemplateDeleteProfile(): void {
        $body = file_get_contents(self::HTML_BUTTON_CLOSE_OVERLAY);
        $body .= file_get_contents(self::HTML_DELETE_PROFILE);
        echo $body;
        exit();
    }

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
}
