<?php

namespace InventoryManagement\DatabaseConnection;

use PDO;

class ConnectionFactory {

    public static function createConnection(): PDO {
        $servername = "localhost";
        $databaseName = "inventory_management";
        $username = "root";
        $password = "";
        return new PDO("mysql:host=$servername;dbname=$databaseName", $username, $password);
    }

    public static function closeConnection(PDO &$conn): void {
        $conn = null;
    }
}
