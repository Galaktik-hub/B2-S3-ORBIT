<?php

class Ship {
    private int $id;
    private string $name;
    private string $camp;
    private float $speed_kmh;
    private int $capacity;

    public function __construct(array $shipArray) {
        $this->id = $shipArray['id'];
        $this->name = $shipArray['name'];
        $this->camp = $shipArray['camp'];
        $this->speed_kmh = $shipArray['speed_kmh'];
        $this->capacity = $shipArray['capacity'];
    }

    // Constructor's call
    public static function loadFromArray(array $shipArray): Ship {
        return new Ship($shipArray);
    }

    public function saveToDatabase(PDO $pdo): void {
        try {
            // Query preparation : INSERT or UPDATE if 'id' already exists
            $stmt = $pdo->prepare("INSERT INTO ships (id, name, camp, speed_kmh, capacity) VALUES (:id, :name, :camp, :speed_kmh, :capacity)
            ON DUPLICATE KEY UPDATE name = :name, camp = :camp, speed_kmh = :speed_kmh, capacity = :capacity");

            $stmt->execute([
                ':id' => $this->id,
                ':name' => $this->name,
                ':camp' => $this->camp,
                ':speed_kmh' => $this->speed_kmh,
                ':capacity' => $this->capacity,
            ]);
        } catch (PDOException $e) {
            echo "Erreur SQL pour le vaisseau ID {$this->id} : " . $e->getMessage() . "<br>";
        }
    }

    // Delete planet from database
    public function clearShip(PDO $pdo) {
        $stmt = $pdo->prepare("DELETE FROM ships WHERE id = :id");
        $stmt->execute([
            ':id' => $this->id
        ]);
    }

    /* Getters and setters */
    public function id(): int { return $this->id; }
    public function setId(int $id): void { $this->id = $id; }

    public function name(): string { return $this->name; }
    public function setName(string $name): void { $this->name = $name; }

    public function camp(): string { return $this->camp; }
    public function setCamp(string $camp): void { $this->camp = $camp; }

    public function speedKmh(): float { return $this->speed_kmh; }
    public function setSpeedKmh(float $speed_kmh): void { $this->speed_kmh = $speed_kmh; }

    public function capacity(): int { return $this->capacity; }
    public function setCapacity(int $capacity): void { $this->capacity = $capacity; }

}
