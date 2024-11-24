<?php

namespace InventoryManagement\DAO;

use InventoryManagement\DatabaseConnection\ConnectionFactory;
use \PDO;
use \PDOException;

class ItemDAO {

    public static function add(int $userId, string $name, int $quantity, string $location, string $description): bool {
        try {
            $conn = ConnectionFactory::createConnection();
            $stmt = $conn->prepare("INSERT INTO item (userId, name, quantity, location, description) VALUES (:userId, :name, :quantity, :location, :description);");
            $stmt->bindValue(":userId", $userId, PDO::PARAM_INT);
            $stmt->bindValue(":name", $name);
            $stmt->bindValue(":quantity", $quantity, PDO::PARAM_INT);
            $stmt->bindValue(":location", $location);
            $stmt->bindValue(":description", $description);
            $success = $stmt->execute();
            ConnectionFactory::closeConnection($conn);
            return $success;
        }
        catch(PDOException $e) {
            http_response_code(500);
            exit();
        }
    }

    public static function read(int $userId): array {
        try {
            $conn = ConnectionFactory::createConnection();
            $stmt = $conn->prepare("SELECT * FROM item WHERE userId = :userId ORDER BY id;");
            $stmt->bindValue(":userId", $userId, PDO::PARAM_INT);
            $stmt->execute();
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            ConnectionFactory::closeConnection($conn);
            return $stmt->fetchAll();
        }
        catch(PDOException $e) {
            http_response_code(500);
            exit();
        }
    }

    public static function readOne(int $itemId): array {
        try {
            $conn = ConnectionFactory::createConnection();
            $stmt = $conn->prepare("SELECT * FROM item WHERE id = :itemId;");
            $stmt->bindValue(":itemId", $itemId, PDO::PARAM_INT);
            $stmt->execute();
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            ConnectionFactory::closeConnection($conn);
            return $stmt->fetch();;
        }
        catch(PDOException $e) {
            http_response_code(500);
            exit();
        }
    }

    public static function update(int $userId, int $id, string $name, int $quantity, string $location, string $description): bool {
        try {
            $conn = ConnectionFactory::createConnection();
            $stmt = $conn->prepare("SELECT userId FROM item WHERE id = :id");
            $stmt->bindValue(":id", $id, PDO::PARAM_INT);
            $stmt->execute();
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $canEdit = $stmt->fetch()["userId"] === $userId;
            if($canEdit) {
                $stmt = $conn->prepare("UPDATE item SET name = :name, quantity = :quantity, location = :location, description = :description WHERE id = :id;");
                $stmt->bindValue(":name", $name);
                $stmt->bindValue(":quantity", $quantity, PDO::PARAM_INT);
                $stmt->bindValue(":location", $location);
                $stmt->bindValue(":description", $description);
                $stmt->bindValue(":id", $id, PDO::PARAM_INT);
                $success = $stmt->execute();
            }
            else {
                $success = false;
            }
            ConnectionFactory::closeConnection($conn);
            return $success;
        }
        catch(PDOException $e) {
            http_response_code(500);
            exit();
        }
    }

    public static function delete(int $userId, int $id): bool {
        try {
            $conn = ConnectionFactory::createConnection();
            $stmt = $conn->prepare("SELECT userId FROM item WHERE id = :id");
            $stmt->bindValue(":id", $id, PDO::PARAM_INT);
            $stmt->execute();
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $canDelete = $stmt->fetch()["userId"] === $userId;
            if($canDelete) {
                $stmt = $conn->prepare("DELETE FROM item WHERE id = :id");
                $stmt->bindValue(":id", $id, PDO::PARAM_INT);
                $success = $stmt->execute();
            }
            else {
                $success = false;
            }
            ConnectionFactory::closeConnection($conn);
            return $success;
        }
        catch(PDOException $e) {
            http_response_code(500);
            exit();
        }
    }

}
