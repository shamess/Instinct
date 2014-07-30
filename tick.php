<?php

require_once 'vendor/autoload.php';

use Instinct\MongoCreatureRepository;
use Instinct\MongoCreatureCreationRepository;
use Instinct\MongoWorldPositionRepository;
use Instinct\Creature\Tick;

$client = new \MongoClient();

$creatureCollection = $client->instinctdb->creature;
$creatureRepository = new MongoCreatureRepository($creatureCollection);

$counterCollection = $client->instinctdb->counters;
$creatureCreationRepository = new MongoCreatureCreationRepository($creatureRepository, $counterCollection);

$worldPositionRepository = new MongoWorldPositionRepository($creatureCollection);

while (true) {
    $creatures = $creatureRepository->find();

    foreach ($creatures as $creature) {
        $originalCreatureData = $creature->toArray();

        $tick = new Tick($creature);
        $tick->tick();
        sleep(3);

        if ($creature->isDead()) {
            echo "Killing [" . $creature->getId() . "]\n";
            $creatureRepository->delete($creature);

            continue;
        }

        if ($creature->wantsToReproduce()) {
            $canBirth = true;
            try {
                $birthingPosition = $worldPositionRepository->findByXY($creature->getX() + rand(-1,1), $creature->getY() + rand(-1,1));
            } catch (\OutOfBoundsException $exception) {
                $canBirth = false;
            }

            if ($canBirth && !$birthingPosition->hasBulkyOccupant()) {
                $newCreature = $creature->reproduceByCloning($birthingPosition->getX(), $birthingPosition->getY());
                $creatureCreationRepository->save($newCreature);

                echo "Added new creature! [" . $newCreature->getX() . "," . $newCreature->getY() . "]\n";
            }
        }

        if ($originalCreatureData !== $creature->toArray()) {
            $creatureRepository->save($creature);
        }
    }
}
