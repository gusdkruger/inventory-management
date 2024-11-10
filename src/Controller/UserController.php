<?php

namespace InventoryManagement\Controller;

use InventoryManagement\DAO\UserDAO;

class UserController {

    public static function login(): void {
        if(isset($_POST["email"]) && isset($_POST["password"])) {
            $email = $_POST["email"];
            $password = $_POST["password"];
            $body = [];
            if(!self::validadeEmail($email)) {
                $body[] = [
                    "input" => "input-email",
                    "valid" => "false",
                    "small" => "email-feedback",
                    "text" => "Email must be between 6 and 255 characters"
                ];
                $body[] = [
                    "input" => "input-password",
                    "value" => "reset"
                ];
            }
            if(!self::validadePassword($password)) {
                $body[] = [
                    "input" => "input-password",
                    "valid" => "false",
                    "value" => "reset",
                    "small" => "password-feedback",
                    "text" => "Password must be between 6 and 255 characters"
                ];
            }
            self::respond(400, $body);
            $userId = UserDAO::login($email, $password);
            if($userId > 0) {
                $_SESSION["userId"] = $userId;
                header("HX-Redirect: /");
                exit();
            }
            else {
                http_response_code(401);
                $body[] = [
                    "input" => "input-email",
                    "valid" => "false"
                ];
                $body[] = [
                    "input" => "input-password",
                    "valid" => "false",
                    "value" => "reset",
                    "small" => "password-feedback",
                    "text" => "Incorrect email or password"
                ];
                self::respond(401, $body);
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
            $body = [];
            if(!self::validadeEmail($email)) {
                $body[] = [
                    "input" => "input-email",
                    "valid" => "false",
                    "small" => "email-feedback",
                    "text" => "Email must be between 6 and 255 characters"
                ];
                $body[] = [
                    "input" => "input-password",
                    "value" => "reset"
                ];
                $body[] = [
                    "input" => "input-password-repeat",
                    "value" => "reset"
                ];
            }
            if(!self::validadePassword($password)) {
                $body[] = [
                    "input" => "input-password",
                    "valid" => "false",
                    "value" => "reset",
                    "small" => "password-feedback",
                    "text" => "Password must be between 6 and 255 characters"
                ];
            }
            if(!self::validadePassword($repeatPassword) || $password !== $repeatPassword) {
                $body[] = [
                    "input" => "input-password",
                    "valid" => "false",
                    "value" => "reset"
                ];
                $body[] = [
                    "input" => "input-password-repeat",
                    "valid" => "false",
                    "value" => "reset",
                    "small" => "password-repeat-feedback",
                    "text" => "Passwords didn't match"
                ];
            }
            self::respond(400, $body);
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
            $body = [];
            if(!self::validadeEmail($newEmail)) {
                $body[] = [
                    "input" => "input-new-email",
                    "valid" => "false",
                    "small" => "new-email-feedback",
                    "text" => "New Email must be between 6 and 255 characters"
                ];
                $body[] = [
                    "input" => "input-password",
                    "value" => "reset"
                ];
            }
            if(!self::validadeEmail($newEmailRepeat) || $newEmail !== $newEmailRepeat) {
                $body[] = [
                    "input" => "input-new-email",
                    "valid" => "false"
                ];
                $body[] = [
                    "input" => "input-new-email-repeat",
                    "valid" => "false",
                    "small" => "new-email-repeat-feedback",
                    "text" => "Emails don't match"
                ];
                $body[] = [
                    "input" => "input-password",
                    "value" => "reset"
                ];
            }
            if(!self::validadePassword($password)) {
                $body[] = [
                    "input" => "input-password",
                    "valid" => "false",
                    "value" => "reset",
                    "small" => "password-feedback",
                    "text" => "Confirm current password"
                ];
            }
            self::respond(400, $body);
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
                    $body[] = [
                        "input" => "input-password",
                        "valid" => "false",
                        "value" => "reset",
                        "small" => "password-feedback",
                        "text" => "Confirm current password"
                    ];
                    self::respond(401, $body);
                }
            }
            else {
                $body[] = [
                    "input" => "input-new-email",
                    "valid" => "false",
                    "small" => "new-email-feedback",
                    "text" => "New email must be different"
                ];
                $body[] = [
                    "input" => "input-new-email-repeat",
                    "valid" => "false"
                ];
                $body[] = [
                    "input" => "input-password",
                    "value" => "reset"
                ];
                self::respond(400, $body);
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
            $body = [];
            if(!self::validadePassword($newPassword)) {
                $body[] = [
                    "input" => "input-new-password",
                    "valid" => "false",
                    "value" => "reset",
                    "small" => "new-password-feedback",
                    "text" => "New password must be between 6 and 255 characters"
                ];
            }
            if(!self::validadePassword($newPasswordRepeat) || $newPassword !== $newPasswordRepeat) {
                $body[] = [
                    "input" => "input-new-password",
                    "valid" => "false",
                    "value" => "reset"
                ];
                $body[] = [
                    "input" => "input-new-password-repeat",
                    "valid" => "false",
                    "value" => "reset",
                    "small" => "new-password-repeat-feedback",
                    "text" => "New passwords didn't match"
                ];
            }
            if(!self::validadePassword($currentPassword)) {
                $body[] = [
                    "input" => "input-new-password",
                    "value" => "reset"
                ];
                $body[] = [
                    "input" => "input-new-password-repeat",
                    "value" => "reset"
                ];
                $body[] = [
                    "input" => "input-password",
                    "valid" => "false",
                    "value" => "reset",
                    "small" => "password-feedback",
                    "text" => "Confirm current password"
                ];
            }
            self::respond(400, $body);
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
                $body[] = [
                    "input" => "input-new-password",
                    "value" => "reset"
                ];
                $body[] = [
                    "input" => "input-new-password-repeat",
                    "value" => "reset"
                ];
                $body[] = [
                    "input" => "input-password",
                    "valid" => "false",
                    "value" => "reset",
                    "small" => "password-feedback",
                    "text" => "Confirm current password"
                ];
                self::respond(401, $body);
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
            $body = [];
            if(!self::validadePassword($password)) {
                $body[] = [
                    "input" => "input-password",
                    "valid" => "false",
                    "value" => "reset",
                    "small" => "password-feedback",
                    "text" => "Confirm current password"
                ];
            }
            self::respond(400, $body);
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
                $body[] = [
                    "input" => "input-password",
                    "valid" => "false",
                    "value" => "reset",
                    "small" => "password-feedback",
                    "text" => "Confirm current password"
                ];
                self::respond(401, $body);
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

    private static function respond(int $code, array $body): void {
        if(count($body) > 0) {
            http_response_code($code);
            header("Content-type: application/json");
            echo json_encode($body);
            exit();
        }
    }
}
