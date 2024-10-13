<?php

namespace InventoryManagement\Controller;

use InventoryManagement\DAO\ItemDAO;
use InventoryManagement\View\View;

class ItemController {

    public static function create(): void {
        if($_SESSION["userId"] > 0 && isset($_POST["name"]) && isset($_POST["quantity"])) {
            $userId = $_SESSION["userId"];
            $name = $_POST["name"];
            $quantity = (int)$_POST["quantity"];
            $location = $_POST["location"] ?? "null";
            $description = $_POST["description"] ?? "null";
            self::validadeName($name);
            self::validadeLocation($location);
            self::validadeDescription($description);
            if(ItemDAO::create($userId, $name, $quantity, $location, $description)) {
                echo "Item added successfully";
                exit();
            }
            else {
                http_response_code(500);
                echo "Failed to add item";
                exit();
            }
        }
        else {
            http_response_code(400);
            exit();
        }
    }

    public static function read(): void {
        if($_SESSION["userId"] > 0) {
            $items = ItemDAO::read($_SESSION["userId"]);
            View::loadList($items);
        }
        else {
            http_response_code(400);
            exit();
        }
    }

    public static function update(): void {
        if($_SESSION["userId"] > 0 && isset($_POST["id"]) && isset($_POST["name"]) && isset($_POST["quantity"])) {
            $userId = $_SESSION["userId"];
            $id = (int)$_POST["id"];
            $name = $_POST["name"];
            $quantity = (int)$_POST["quantity"];
            $location = $_POST["location"] ?? "null";
            $description = $_POST["description"] ?? "null";
            self::validadeName($name);
            self::validadeLocation($location);
            self::validadeDescription($description);
            if(ItemDAO::update($userId, $id, $name, $quantity, $location, $description)) {
                echo "Item updated successfully";
                exit();
            }
            else {
                http_response_code(500);
                echo "Failed to updated item";
                exit();
            }
        }
        else {
            http_response_code(400);
            exit();
        }
    }

    public static function delete(): void {
        if($_SESSION["userId"] > 0 && isset($_POST["id"])) {
            if(ItemDAO::delete($_SESSION["userId"], $_POST["id"])) {
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


    private static function validadeName(string $name): void {
        if(strlen($name) > 255) {
            http_response_code(400);
            echo "Name must be less than 255 characters";
            exit();
        }
    }

    private static function validadeLocation(string $location): void {
        if(strlen($location) > 255) {
            http_response_code(400);
            echo "Location must be less than 256 characters";
            exit();
        }
    }

    private static function validadeDescription(string $description): void {
        if(strlen($description) > 255) {
            http_response_code(400);
            echo "Description must be less than 256 characters";
            exit();
        }
    }
}
