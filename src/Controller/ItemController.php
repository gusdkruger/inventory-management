<?php

namespace InventoryManagement\Controller;

use InventoryManagement\DAO\ItemDAO;
use InventoryManagement\View\View;

class ItemController {

    public static function add(): void {
        if($_SESSION["userId"] > 0 && isset($_POST["name"]) && isset($_POST["quantity"])) {
            $userId = $_SESSION["userId"];
            $name = $_POST["name"];
            $quantity = $_POST["quantity"] ?? 0;
            $location = $_POST["location"] ?? "null";
            $description = $_POST["description"] ?? "null";
            $body = [];
            if(!self::validadeStringObligatory($name)) {
                $body[] = [
                    "input" => "input-name",
                    "valid" => "false",
                    "small" => "name-feedback",
                    "text" => "Name must be between 1 and 255 characters"
                ];
            }
            if(!self::validadeQuantity($quantity)) {
                $body[] = [
                    "input" => "input-quantity",
                    "valid" => "false",
                    "small" => "quantity-feedback",
                    "text" => "Quantity must be a number between 0 and 999.999.999"
                ];
            }
            if(!self::validadeStringOptional($location)) {
                $body[] = [
                    "input" => "input-location",
                    "valid" => "false",
                    "small" => "location-feedback",
                    "text" => "Location must be less than 256 characters"
                ];
            }
            if(!self::validadeStringOptional($description)) {
                $body[] = [
                    "input" => "input-description",
                    "valid" => "false",
                    "small" => "description-feedback",
                    "text" => "Description must be less than 256 characters"
                ];
            }
            self::respond(400, $body);
            if(ItemDAO::add($userId, $name, $quantity, $location, $description)) {
                http_response_code(200);
                header("HX-Retarget: #toast");
                header("HX-Reswap: none");
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

    public static function read(): void {
        if($_SESSION["userId"] > 0) {
            $items = ItemDAO::read($_SESSION["userId"]);
            header("Content-type: application/json");
            echo json_encode($items);
            exit();
        }
        else {
            http_response_code(401);
            exit();
        }
    }

    /*
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
    */

    public static function delete(): void {
        if($_SESSION["userId"] > 0 && isset($_POST["id"])) {
            if(ItemDAO::delete($_SESSION["userId"], $_POST["id"])) {
                http_response_code(200);
                exit();
            }
            else {
                http_response_code(401);
                exit();
            }
        }
        else {
            http_response_code(400);
            exit();
        }
    }

    /*
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
    */

    private static function validadeStringObligatory(string $string): bool {
        if(!$string || strlen($string) > 255) {
            return false;
        }
        else {
            return true;
        }
    }

    private static function validadeStringOptional(string $string): bool {
        if(strlen($string) > 255) {
            return false;
        }
        else {
            return true;
        }
    }

    private static function validadeQuantity(string $quantity): bool {
        return is_numeric($quantity) && $quantity >= 0 && $quantity <= 999999999;
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
