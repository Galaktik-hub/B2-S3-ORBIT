<?php
// Call $pdo to connect to database
include '../back/cnx.php';

include 'ship.php';

// Set of Ships
class ShipTab {
    private array $ships;

    private function __construct(array $array) {
        $this->ships = $array;
    }

    // Load ships from JSON file
    public static function loadAllShipFromJson(string $jsonFilePath): ShipTab {
        if (!file_exists($jsonFilePath)) {
            throw new Exception("json file not found");
        }

        $jsonContents = file_get_contents($jsonFilePath);
        $shipsData = json_decode($jsonContents, true);
        $ships = array();

        // Ship initialisation
        foreach ($shipsData as $ship) {
            $ships[] = Ship::loadFromArray($ship);
        }
        return new ShipTab($ships);
    }

    // Save all items to database
    public function saveAllToDatabase(): void {
        global $pdo;
        foreach ($this->ships as $ship) {
            $ship->saveToDatabase($pdo);
        }
    }

    // Delete all items from database
    public function clearAllShipsFromDatabase(): void {
        global $pdo;
        foreach ($this->ships as $ship) {
            $ship->clearShip($pdo);
        }
    }

    // Display function of Ship object
    public function displayAllShips(): void {
        foreach ($this->ships as $ship) {
            echo "ID: ". $ship->id() . "<br>";
            echo "Name: ". $ship->name() . "<br>";
            echo "Camp: ". $ship->camp() . "<br>";
            echo "Speed: ". $ship->speedKmh() . "<br>";
            echo "Capacity: ". $ship->capacity() . "<br><br>";
        }
    }
}