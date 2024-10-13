<?php

namespace InventoryManagement\View;

use InventoryManagement\DAO\ItemDAO;

class View {
    private const HTML_START = __DIR__ . "/html/start.html";
    private const HTML_END = __DIR__ . "/html/end.html";

    private const HTML_LOGIN = __DIR__ . "/html/login.html";
    private const HTML_SIGNUP = __DIR__ . "/html/signup.html";

    private const HTML_HEADER = __DIR__ . "/html/header.html";
    private const HTML_MAIN = __DIR__ . "/html/main.html";

    private const HTML_OVERLAY = __DIR__ . "/html/overlay.html";
    private const HTML_BUTTON_CLOSE_OVERLAY = __DIR__ . "/html/buttonCloseOverlay.html";

    private const HTML_CHANGE_EMAIL = __DIR__ . "/html/changeEmail.html";
    private const HTML_CHANGE_PASSWORD = __DIR__ . "/html/changePassword.html";
    private const HTML_DELETE_PROFILE = __DIR__ . "/html/deleteProfile.html";

    private const HTML_ADD_ITEM = __DIR__ . "/html/addItem.html";
    private const HTML_NO_ITEMS = __DIR__ . "/html/noItems.html";
    private const HTML_TABLE_HEADER = __DIR__ . "/html/tableHeader.html";
    private const PHP_ITEM = __DIR__ . "/html/item.php";
    private const PHP_EDIT_ITEM = __DIR__ . "/html/editItem.php";

    public static function load(): void {
        $body = file_get_contents(self::HTML_START);
        if($_SESSION["userId"] > 0) {
            $body .= file_get_contents(self::HTML_OVERLAY);
            $body .= file_get_contents(self::HTML_HEADER);
            $body .= file_get_contents(self::HTML_MAIN);
        }
        else {
            $body .= file_get_contents(self::HTML_LOGIN);
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

    public static function getTemplateLogin(): void {
        echo file_get_contents(self::HTML_LOGIN);
        exit();
    }

    public static function getTemplateSignup(): void {
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
