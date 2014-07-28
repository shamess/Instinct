<?php

require_once 'vendor/autoload.php';

use Instinct\MongoCreatureRepository;
use Instinct\MongoCreatureCreationRepository;
use Instinct\MongoWorldPositionRepository;

$client = new \MongoClient();

$creatureCollection = $client->instinctdb->creature;
$creatureRepository = new MongoCreatureRepository($creatureCollection);

$counterCollection = $client->instinctdb->counters;
$creatureCreationRepository = new MongoCreatureCreationRepository($creatureRepository, $counterCollection);

$worldPositionRepository = new MongoWorldPositionRepository($creatureCollection);

while (true) {
    $creatures = $creatureRepository->find();

    foreach ($creatures as $creature) {
        sleep(5);

        if ($creature->wantsToReproduce()) {
            $birthingPosition = $worldPositionRepository->findByXY($creature->getX() + rand(-1,1), $creature->getY() + rand(-1,1));

            if ($birthingPosition->hasBulkyOccupant()) {
                continue;
            }

            $newCreature = $creature->reproduceByCloning($birthingPosition->getX(), $birthingPosition->getY());
            $creatureCreationRepository->save($newCreature);

            echo "Added new creature! [" . $newCreature->getX() . "," . $newCreature->getY() . "]\n";
        }
    }
}
