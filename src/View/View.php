<?php

namespace InventoryManagement\View;

class View {
    private const HTML_START = __DIR__ . "/html/start.html";
    private const HTML_END = __DIR__ . "/html/end.html";

    private const HTML_LOGIN = __DIR__ . "/html/login.html";
    private const HTML_SIGNUP = __DIR__ . "/html/signup.html";

    private const HTML_LOGGED = __DIR__ . "/html/logged.html";

    public static function load(): void {
        $body = file_get_contents(self::HTML_START);
        if($_SESSION["userId"] > 0) {
            $body .= file_get_contents(self::HTML_LOGGED);
        }
        else {
            $body .= file_get_contents(self::HTML_LOGIN);
        }
        $body .= file_get_contents(self::HTML_END);
        echo $body;
        exit();
    }

    public static function getTemplateLogin(): void {
        echo file_get_contents(self::HTML_LOGIN);
    }

    public static function getTemplateSignup(): void {
        echo file_get_contents(self::HTML_SIGNUP);
    }
}
