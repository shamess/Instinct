<?php

require_once 'vendor/autoload.php';

use Instinct\MongoCreatureRepository;
use Instinct\MongoCreatureCreationRepository;
use Instinct\MongoWorldPositionRepository;
use Instinct\Creature\Tick;
use Instinct\Intent\Arbitrator\MovementArbitrator;

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
        $canStillAct = true;

        $tick = new Tick($creature);
        $tick->tick();
        sleep(3);

        if ($creature->isDead()) {
            echo "Killing [" . $creature->getId() . "]\n";
            $creatureRepository->delete($creature);

            continue;
        }

        if ($canStillAct && $creature->wantsToMove()) {
            $movementArbitrator = new MovementArbitrator($creature, $worldPositionRepository);
            $intendedPosition = $movementArbitrator->getPositionToMoveTo();

            if ($intendedPosition && !$intendedPosition->hasBulkyOccupant()) {
                echo "Moving " . $creature->getId() . " to [" . $intendedPosition->getX() . "," . $intendedPosition->getY() . "]\n";
                $creature->move($intendedPosition);

                $canStillAct = false;
            }
        }

        if ($canStillAct && $creature->wantsToReproduce()) {
            $canBirth = true;
            try {
                $birthingPosition = $worldPositionRepository->findByXY($creature->getX() + rand(-1,1), $creature->getY() + rand(-1,1));
            } catch (\OutOfBoundsException $exception) {
                $canBirth = false;
            }

            if ($canBirth && !$birthingPosition->hasBulkyOccupant()) {
                $newCreature = $creature->reproduceByCloning($birthingPosition->getX(), $birthingPosition->getY());
                $creatureCreationRepository->save($newCreature);

                $canStillAct = false;

                echo "Added new creature! [" . $newCreature->getX() . "," . $newCreature->getY() . "]\n";
            }
        }

        if ($originalCreatureData !== $creature->toArray()) {
            $creatureRepository->save($creature);
        }
    }
}
