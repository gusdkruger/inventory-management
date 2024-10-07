<?php

namespace InventoryManagement\DAO;

use InventoryManagement\DatabaseConnection\ConnectionFactory;
use \PDO;
use \PDOException;

class UserDAO {

    public static function login(string $email, string $password): int {
        try {
            $conn = ConnectionFactory::createConnection();
            $stmt = $conn->prepare("SELECT id, password FROM user WHERE email = :email;");
            $stmt->bindValue(":email", $email);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            ConnectionFactory::closeConnection($conn);
            if(password_verify($password, $result["password"] ?? "")) {
                return $result["id"];
            }
            else {
                return 0;
            }
        }
        catch(PDOException $e) {
            http_response_code(500);
            exit();
        }
    }

    public static function signup(string $email, string $passwordHash): int {
        try {
            $conn = ConnectionFactory::createConnection();
            $stmt = $conn->prepare("INSERT INTO user (email, password) VALUES (:email, :passwordHash);");
            $stmt->bindValue(":email", $email);
            $stmt->bindValue(":passwordHash", $passwordHash);
            $stmt->execute();
            $id = $conn->lastInsertId() ?? 0;
            ConnectionFactory::closeConnection($conn);
            return $id;
        }
        catch(PDOException $e) {
            if($e->getCode() === "23000") {
                http_response_code(400);
                echo "Email is already in use";
                exit();
            }
            else {
                http_response_code(500);
                exit();
            }
        }
    }

    public static function getEmail(int $id): string {
        try {
            $conn = ConnectionFactory::createConnection();
            $stmt = $conn->prepare("SELECT email FROM user WHERE id = :id;");
            $stmt->bindValue(":id", $id);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            ConnectionFactory::closeConnection($conn);
            return $result["email"];
        }
        catch(PDOException $e) {
            http_response_code(500);
            exit();
        }
    }

    public static function validatePassword(int $id, string $password): bool {
        try {
            $conn = ConnectionFactory::createConnection();
            $stmt = $conn->prepare("SELECT password FROM user WHERE id = :id;");
            $stmt->bindValue(":id", $id);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            ConnectionFactory::closeConnection($conn);
            return password_verify($password, $result["password"] ?? "");
        }
        catch(PDOException $e) {
            http_response_code(500);
            exit();
        }
    }

    public static function changeEmail(int $id, string $email): bool {
        try {
            $conn = ConnectionFactory::createConnection();
            $stmt = $conn->prepare("UPDATE user SET email = :email WHERE id = :id;");
            $stmt->bindValue(":id", $id);
            $stmt->bindValue(":email", $email);
            $success = $stmt->execute();
            ConnectionFactory::closeConnection($conn);
            return $success;
        }
        catch(PDOException $e) {
            http_response_code(500);
            exit();
        }
    }

    public static function changePassword(int $id, string $passwordHash): bool {
        try {
            $conn = ConnectionFactory::createConnection();
            $stmt = $conn->prepare("UPDATE user SET password = :password WHERE id = :id;");
            $stmt->bindValue(":id", $id);
            $stmt->bindValue(":password", $passwordHash);
            $success = $stmt->execute();
            ConnectionFactory::closeConnection($conn);
            return $success;
        }
        catch(PDOException $e) {
            http_response_code(500);
            exit();
        }
    }
}
