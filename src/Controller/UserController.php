<?php

namespace InventoryManagement\Controller;

use InventoryManagement\DAO\UserDAO;

class UserController {

    public static function login(): void {
        if(isset($_POST["email"]) && isset($_POST["password"])) {
            $email = $_POST["email"];
            $password = $_POST["password"];
            self::validadeEmail($email);
            self::validadePassword($password);
            $userId = UserDAO::login($email, $password);
            if($userId > 0) {
                $_SESSION["userId"] = $userId;
                header("HX-Redirect: /");
                exit();
            }
            else {
                http_response_code(401);
                echo "Invalid email or password";
                exit();
            }
        }
        else {
            http_response_code(400);
            exit();
        }
    }

    public static function logout(): void {
        $_SESSION["userId"] = null;
        http_response_code(303);
        header("HX-Redirect: /");
        exit();
    }

    public static function signup(): void {
        if(isset($_POST["email"]) && isset($_POST["password"]) && isset($_POST["password-repeat"])) {
            $email = $_POST["email"];
            $password = $_POST["password"];
            self::validadeEmail($email);
            self::validadePassword($password);
            if($password === $_POST["password-repeat"]) {
                $passwordHash = password_hash($password, PASSWORD_ARGON2ID);
                $userId = UserDAO::signup($email, $passwordHash);
                if($userId > 0) {
                    $_SESSION["userId"] = $userId;
                    http_response_code(201);
                    header("HX-Redirect: /");
                    exit();
                }
            }
            else {
                http_response_code(400);
                echo "Passwords don't match";
                exit();
            }
        }
        else {
            http_response_code(400);
            exit();
        }
    }

    public static function getEmail(): void {
        if($_SESSION["userId"] > 0) {
            echo UserDAO::getEmail($_SESSION["userId"]);
            exit();
        }
        else {
            http_response_code(400);
            exit();
        }
    }

    private static function validadeEmail(string $email): void {
        if(strlen($email) < 6 || strlen($email) > 255 || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            http_response_code(400);
            echo "Email must be between 6 and 255 characters";
            exit();
        }
    }

    private static function validadePassword(string $password): void {
        if(strlen($password) < 6 || strlen($password) > 255) {
            http_response_code(400);
            echo "Password must be between 6 and 255 characters";
            exit();
        }
    }
}
