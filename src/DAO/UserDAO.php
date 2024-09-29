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
            echo $e;
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
            http_response_code(500);
            echo $e;
            exit();
        }
    }
}
