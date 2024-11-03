<?php

namespace InventoryManagement\Controller;

use InventoryManagement\DAO\UserDAO;

class UserController {

    public static function login(): void {
        if(isset($_POST["email"]) && isset($_POST["password"])) {
            $email = $_POST["email"];
            $password = $_POST["password"];
            $hxTrigger = [];
            if(!self::validadeEmail($email)) {
                $hxTrigger[] = "invalidEmail";
            }
            if(!self::validadePassword($password)) {
                $hxTrigger[] = "invalidPassword";
            }
            self::respond($hxTrigger);
            $userId = UserDAO::login($email, $password);
            if($userId > 0) {
                $_SESSION["userId"] = $userId;
                header("HX-Redirect: /");
                exit();
            }
            else {
                http_response_code(401);
                header("HX-Trigger: invalidLoginInfo");
                exit();
            }
        }
        else {
            http_response_code(400);
            exit();
        }
    }

    public static function logout(): void {
        unset($_SESSION["userId"]);
        http_response_code(303);
        header("HX-Redirect: /");
        exit();
    }

    public static function signup(): void {
        if(isset($_POST["email"]) && isset($_POST["password"]) && isset($_POST["password-repeat"])) {
            $email = $_POST["email"];
            $password = $_POST["password"];
            $repeatPassword = $_POST["password-repeat"];
            $hxTrigger = [];
            if(!self::validadeEmail($email)) {
                $hxTrigger[] = "invalidEmail";
            }
            if(!self::validadePassword($password)) {
                $hxTrigger[] = "invalidPassword";
            }
            if(!self::validadePassword($repeatPassword) || $password !== $repeatPassword) {
                $hxTrigger[] = "passwordsDidntMatch";
            }
            self::respond($hxTrigger);
            $passwordHash = password_hash($password, PASSWORD_ARGON2ID);
            $userId = UserDAO::signup($email, $passwordHash);
            if($userId > 0) {
                $_SESSION["userId"] = $userId;
                http_response_code(201);
                header("HX-Redirect: /");
                exit();
            }
            else {
                http_response_code(500);
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

    public static function changeEmail(): void {
        if($_SESSION["userId"] > 0 && isset($_POST["new-email"]) && isset($_POST["new-email-repeat"]) && isset($_POST["password"])) {
            $userId = $_SESSION["userId"];
            $newEmail = $_POST["new-email"];
            $newEmailRepeat = $_POST["new-email-repeat"];
            $password = $_POST["password"];
            $hxTrigger = [];
            if(!self::validadeEmail($newEmail)) {
                $hxTrigger[] = "invalidEmail";
            }
            if(!self::validadeEmail($newEmailRepeat) || $newEmail !== $newEmailRepeat) {
                $hxTrigger[] = "emailsDontMatch";
            }
            if(!self::validadePassword($password)) {
                $hxTrigger[] = "invalidPassword";
            }
            self::respond($hxTrigger);
            if($newEmail !== UserDAO::getEmail($userId)) {
                if(UserDAO::validatePassword($userId, $password)) {
                    if(UserDAO::changeEmail($userId, $newEmail)) {
                        self::logout();
                    }
                    else {
                        http_response_code(500);
                        exit();
                    }
                }
                else {
                    http_response_code(401);
                    header("HX-Trigger: wrongPassword");
                    exit();
                }
            }
            else {
                http_response_code(400);
                header("HX-Trigger: emailMustBeDifferent");
                exit();
            }
        }
        else {
            http_response_code(400);
            exit();
        }
    }

    public static function changePassword(): void {
        if($_SESSION["userId"] > 0 && isset($_POST["new-password"]) && isset($_POST["new-password-repeat"]) && isset($_POST["password"])) {
            $userId = $_SESSION["userId"];
            $newPassword = $_POST["new-password"];
            $newPasswordRepeat = $_POST["new-password-repeat"];
            $currentPassword = $_POST["password"];
            $hxTrigger = [];
            if(!self::validadePassword($newPassword)) {
                $hxTrigger[] = "invalidNewPassword";
            }
            if(!self::validadePassword($newPasswordRepeat) || $newPassword !== $newPasswordRepeat) {
                $hxTrigger[] = "newPasswordsDidntMatch";
            }
            if(!self::validadePassword($currentPassword)) {
                $hxTrigger[] = "invalidPassword";
            }
            self::respond($hxTrigger);
            if($newPassword === $newPasswordRepeat) {
                if(UserDAO::validatePassword($userId, $currentPassword)) {
                    $passwordHash = password_hash($newPassword, PASSWORD_ARGON2ID);
                    if(UserDAO::changePassword($userId, $passwordHash)) {
                        self::logout();
                    }
                    else {
                        http_response_code(500);
                        exit();
                    }
                }
                else {
                    http_response_code(401);
                    header("HX-Trigger: wrongPassword");
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

    public static function delete(): void {
        if($_SESSION["userId"] > 0 && isset($_POST["password"])) {
            $userId = $_SESSION["userId"];
            $password = $_POST["password"];
            self::validadePassword($password);
            if(UserDAO::validatePassword($userId, $password)) {
                if(UserDAO::delete($userId)) {
                    self::logout();
                }
                else {
                    http_response_code(500);
                    exit();
                }
            }
            else {
                http_response_code(401);
                echo "Invalid password";
                exit();
            }
        }
        else {
            http_response_code(400);
            exit();
        }
    }

    private static function validadeEmail(string $email): bool {
        if(strlen($email) < 6 || strlen($email) > 255 || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return false;
        }
        else {
            return true;
        }
    }

    private static function validadePassword(string $password): bool {
        if(strlen($password) < 6 || strlen($password) > 255) {
            return false;
        }
        else {
            return true;
        }
    }

    private static function respond(array $hxTrigger): void {
        if(count($hxTrigger) > 0) {
            http_response_code(400);
            $header = "HX-Trigger: " . $hxTrigger[0];
            for($i = 1; $i < count($hxTrigger); $i++) {
                $header .= ", " . $hxTrigger[$i];
            }
            header($header);
            exit();
        }
    }
}
