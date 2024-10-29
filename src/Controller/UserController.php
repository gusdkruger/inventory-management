<?php

namespace InventoryManagement\Controller;

use InventoryManagement\DAO\UserDAO;

class UserController {

    public static function login(): void {
        if(isset($_POST["email"]) && isset($_POST["password"])) {
            $email = $_POST["email"];
            $password = $_POST["password"];
            self::validateData($email, $password);
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
            http_response_code(500);
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
            self::validateData($email, $password);
            if($password === $_POST["password-repeat"]) {
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
                header("HX-Trigger: passwordsDontMatch");
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
            $password = $_POST["password"];
            self::validadeEmail($newEmail);
            self::validadePassword($password);
            if($newEmail === $_POST["new-email-repeat"]) {
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
                        echo "Invalid password";
                        exit();
                    }
                }
                else {
                    http_response_code(401);
                    echo "New email must be different";
                    exit();
                }
            }
            else {
                http_response_code(400);
                echo "Emails don't match";
                exit();
            }
        }
        else {
            http_response_code(400);
            exit();
        }
    }

    public static function changePassword(): void {
        if($_SESSION["userId"] > 0 && isset($_POST["new-password"]) && isset($_POST["new-password-repeat"]) && isset($_POST["current-password"])) {
            $userId = $_SESSION["userId"];
            $newPassword = $_POST["new-password"];
            $currentPassword = $_POST["current-password"];
            self::validadePassword($newPassword);
            if($newPassword === $_POST["new-password-repeat"]) {
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
                    echo "Invalid password";
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

    private static function validateData(string $email, string $password): bool {
        $trigger = "HX-Trigger: ";
        $valid = true;
        if(!self::validadeEmail($email)) {
            $trigger .= "invalidEmail";
            $valid = false;
        }
        if(!self::validadePassword($password)) {
            if($valid) {
                $trigger .= "invalidPassword";
            }
            else {
                $trigger .= ", invalidPassword";
            }
            $valid = false;
        }
        if(!$valid) {
            http_response_code(400);
            header($trigger);
            exit();
        }
        return $valid;
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
}
