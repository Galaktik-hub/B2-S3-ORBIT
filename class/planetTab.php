<?php
// Call $pdo to connect to database
include '../back/cnx.php';

include 'planet.php';

// Set of Planets
class PlanetTab {
    private array $planets;

    private function __construct(array $array) {
        $this->planets = $array;
    }

    // Load planets from JSON file
    public static function loadAllPlanetFromJson(string $jsonFilePath): PlanetTab {
        if (!file_exists($jsonFilePath)) {
            throw new Exception("Planet tab file does not exist");
        }

        $jsonContents = file_get_contents($jsonFilePath);
        $planetsData = json_decode($jsonContents, true);
        $planets = array();

        // Planet initialisation
        foreach ($planetsData as $planet) {
            $planets[] = Planet::loadFromArray($planet);
        }
        return new PlanetTab($planets);
    }

    // Save all items to database
    public function saveAllToDatabase(): void {
        global $pdo;
        foreach ($this->planets as $planet) {
            $planet->saveToDatabase($pdo);
        }
    }

    // Delete all items from database
    public function clearAllPlanetsFromDatabase(): void {
        global $pdo;
        foreach ($this->planets as $planet) {
            $planet->clearPlanet($pdo);
        }
    }

    // Display function of Planet object
    public function displayAllPlanets(): void {
        foreach ($this->planets as $planet) {
            echo "ID: " . $planet->id() . "<br>";
            echo "Name: " . $planet->name() . "<br>";
            echo "Image: " . $planet->displayPlanetImage() . "<br>";
            echo "Coordinates: " . ($planet->coord() ?? 'No coords available'). "<br>";
            echo "X: " . $planet->x() . "<br>";
            echo "Y: " . $planet->y() . "<br>";
            echo "SubGridCoord: " . ($planet->subGridCoord() ?? 'No subGridCoord available') . "<br>";
            echo "SubGridX: " . $planet->subGridX() . "<br>";
            echo "SubGridY: " . $planet->subGridY() . "<br>";
            echo "Sun Name: " . ($planet->sunName() ?? 'No sun information') . "<br>";
            echo "Region: " . $planet->region() . "<br>";
            echo "Sector: " . $planet->sector() . "<br>";
            echo "Number of Suns: " . $planet->suns() . "<br>";
            echo "Number of Moons: " . $planet->moons() . "<br>";
            echo "Orbital Position: " . $planet->position() . "<br>";
            echo "Distance from Core (light years): " . $planet->distance() . "<br>";
            echo "Day Length (hours): " . $planet->lengthDay() . "<br>";
            echo "Year Length (days): " . $planet->lengthYear() . "<br>";
            echo "Diameter (km): " . $planet->diameter() . "<br>";
            echo "Gravity: " . $planet->gravity() . "<br><br>";
            echo "Trips: " . $planet->trips() . "<br>";
        }
    }
}
