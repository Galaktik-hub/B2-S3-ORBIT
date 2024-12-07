<?php

class Planet {
    private int $id;
    private string $name;
    private ?string $image;
    private ?string $coord;
    private float $x;
    private float $y;
    private ?string $subGridCoord;
    private float $subGridX;
    private float $subGridY;
    private ?string $sunName;
    private string $region;
    private string $sector;
    private int $suns;
    private int $moons;
    private int $position;
    private float $distance;
    private float $lengthDay;
    private float $lengthYear;
    private float $diameter;
    private float $gravity;
    private array $trips;

    public function __construct(array $planetArray) {
        $this->id = $planetArray["Id"];
        $this->name = $planetArray['Name'];
        $this->image = $planetArray['Image'] ?? null;
        $this->coord = $planetArray['Coord'] ?? null;
        $this->x = $planetArray['X'];
        $this->y = $planetArray['Y'];
        $this->subGridCoord = $planetArray['SubGridCoord'] ?? null;
        $this->subGridX = $planetArray['SubGridX'];
        $this->subGridY = $planetArray['SubGridY'];
        $this->sunName = $planetArray['SunName'] ?? null;
        $this->region = $planetArray['Region'];
        $this->sector = $planetArray['Sector'];
        $this->suns = $planetArray['Suns'];
        $this->moons = $planetArray['Moons'];
        $this->position = $planetArray['Position'];
        $this->distance = $planetArray['Distance'];
        $this->lengthDay = $planetArray['LengthDay'];
        $this->lengthYear = $planetArray['LengthYear'];
        $this->diameter = $planetArray['Diameter'];
        $this->gravity = $planetArray['Gravity'];
        $this->trips = $planetArray['trips'];
    }

    // Constructor's call
    public static function loadFromArray(array $planetArray): Planet {
        return new Planet($planetArray);
    }

    public function saveToDatabase(PDO $pdo): void {
        try {
            // Query preparation : INSERT or UPDATE if 'id' already exists
            $stmt = $pdo->prepare(
                "INSERT INTO planets (id, name, image, coord, x, y, sub_grid_coord, sub_grid_x, sub_grid_y, sun_name, region, sector, suns, moons, position, distance, length_day, length_year, diameter, gravity)
            VALUES (:id, :name, :image, :coord, :x, :y, :subGridCoord, :subGridX, :subGridY, :sunName, :region, :sector, :suns, :moons, :position, :distance, :lengthDay, :lengthYear, :diameter, :gravity)
            ON DUPLICATE KEY UPDATE
                name = :name, image = :image, coord = :coord, x = :x, y = :y, sub_grid_coord = :subGridCoord, sub_grid_x = :subGridX, sub_grid_y = :subGridY,
                sun_name = :sunName, region = :region, sector = :sector, suns = :suns, moons = :moons, position = :position, distance = :distance,
                length_day = :lengthDay, length_year = :lengthYear, diameter = :diameter, gravity = :gravity
            ");

            $stmt->execute([
                ':id' => $this->id,
                ':name' => $this->name,
                ':image' => $this->image,
                ':coord' => $this->coord,
                ':x' => $this->x,
                ':y' => $this->y,
                ':subGridCoord' => $this->subGridCoord,
                ':subGridX' => $this->subGridX,
                ':subGridY' => $this->subGridY,
                ':sunName' => $this->sunName,
                ':region' => $this->region,
                ':sector' => $this->sector,
                ':suns' => $this->suns,
                ':moons' => $this->moons,
                ':position' => $this->position,
                ':distance' => $this->distance,
                ':lengthDay' => $this->lengthDay,
                ':lengthYear' => $this->lengthYear,
                ':diameter' => $this->diameter,
                ':gravity' => $this->gravity
            ]);

            // Eliminating existing trips for the planet
            $deleteStmt = $pdo->prepare("DELETE FROM trips WHERE planet_id = :planet_id");
            $deleteStmt->execute([':planet_id' => $this->id]);

            // Trips registration
            $this->saveTripsToDatabase($pdo);
        } catch (PDOException $e) {
            echo "Erreur SQL pour la planète ID {$this->id} : " . $e->getMessage() . "<br>";
        }
    }

    public function saveTripsToDatabase(PDO $pdo): void {
        try {
            $stmt = $pdo->prepare(
                "INSERT INTO trips (planet_id, day_of_week, destination_planet_id, departure_time, ship_id)
            VALUES (:planetId, :dayOfWeek, :destinationPlanetId, :departureTime, :shipId)"
            );
            // Iterate through each day of the week with its associated trips
            foreach ($this->trips as $dayOfWeek => $tripsForDay) {
                // For each trip scheduled for this day
                foreach ($tripsForDay as $trip) {
                    $stmt->execute([
                        ':planetId' => $this->id,
                        ':dayOfWeek' => $dayOfWeek,
                        ':destinationPlanetId' => $trip['destination_planet_id'][0],
                        ':departureTime' => $trip['departure_time'][0],
                        ':shipId' => $trip['ship_id'][0]
                    ]);
                }
            }
        } catch (PDOException $e) {
            echo "Erreur lors de l'enregistrement des voyages pour la planète ID {$this->id} : " . $e->getMessage() . "<br>";
        }
    }

    // Delete planet from database
    public function clearPlanet(PDO $pdo): void {
        $stmt = $pdo->prepare("DELETE FROM planets WHERE id = :id");
        $stmt->execute([
            ':id' => $this->id,
        ]);
        $stmt = $pdo->prepare("DELETE FROM trips WHERE planet_id = :id");
        $stmt->execute([
            ':id' => $this->id,
        ]);
    }

    // Get the url from image name
    public function displayPlanetImage(): string {
        if ($this->image()) {
            $imageName = str_replace(' ', '_', $this->image());
            $md5Hash = md5($imageName);
            $url = "https://static.wikia.nocookie.net/starwars/images/" . $md5Hash[0] . "/" . substr($md5Hash, 0, 2) . "/" . $imageName;
            return "<img src='$url' alt='Image of {$this->name()}' />";
        }
        return "No image available";
    }

    /* Getters and setters */
    public function id(): int { return $this->id; }
    public function setId(int $id): void { $this->id = $id; }

    public function name(): string { return $this->name; }
    public function setName(string $name): void { $this->name = $name; }

    public function image(): ?string { return $this->image; }
    public function setImage(?string $image): void { $this->image = $image; }

    public function coord(): ?string { return $this->coord; }
    public function setCoord(?string $coord): void { $this->coord = $coord; }

    public function x(): float { return $this->x; }
    public function setX(float $x): void { $this->x = $x; }

    public function y(): float { return $this->y; }
    public function setY(float $y): void { $this->y = $y; }

    public function subGridCoord(): ?string { return $this->subGridCoord; }
    public function setSubGridCoord(?string $subGridCoord): void { $this->subGridCoord = $subGridCoord; }

    public function subGridX(): float { return $this->subGridX; }
    public function setSubGridX(float $subGridX): void { $this->subGridX = $subGridX; }

    public function subGridY(): float { return $this->subGridY; }
    public function setSubGridY(float $subGridY): void { $this->subGridY = $subGridY; }

    public function sunName(): ?string { return $this->sunName; }
    public function setSunName(?string $sunName): void { $this->sunName = $sunName; }

    public function region(): string { return $this->region; }
    public function setRegion(string $region): void { $this->region = $region; }

    public function sector(): string { return $this->sector; }
    public function setSector(string $sector): void { $this->sector = $sector; }

    public function suns(): int { return $this->suns; }
    public function setSuns(int $suns): void { $this->suns = $suns; }

    public function moons(): int { return $this->moons; }
    public function setMoons(int $moons): void { $this->moons = $moons; }

    public function position(): int { return $this->position; }
    public function setPosition(int $position): void { $this->position = $position; }

    public function distance(): float { return $this->distance; }
    public function setDistance(float $distance): void { $this->distance = $distance; }

    public function lengthDay(): float { return $this->lengthDay; }
    public function setLengthDay(float $lengthDay): void { $this->lengthDay = $lengthDay; }

    public function lengthYear(): float { return $this->lengthYear; }
    public function setLengthYear(float $lengthYear): void { $this->lengthYear = $lengthYear; }

    public function diameter(): float { return $this->diameter; }
    public function setDiameter(float $diameter): void { $this->diameter = $diameter; }

    public function gravity(): float { return $this->gravity; }
    public function setGravity(float $gravity): void { $this->gravity = $gravity; }

    public function trips(): array { return $this->trips; }
    public function setTrips(array $trips): void { $this->trips = $trips; }

}
