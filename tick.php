<?php

require_once 'vendor/autoload.php';

use Instinct\MongoCreatureRepository;
use Instinct\MongoCreatureCreationRepository;

$client = new \MongoClient();

$creatureCollection = $client->instinctdb->creature;
$creatureRepository = new MongoCreatureRepository($creatureCollection);

while (true) {
    $creatures = $creatureRepository->find();

    foreach ($creatures as $creature) {
        if ($creature->wantsToReproduce()) {
            $counterCollection = $client->instinctdb->counters;
            $creatureCreationRepository = new MongoCreatureCreationRepository($creatureRepository, $counterCollection);

            $newCreature = $creature->reproduceByCloning($creature->getX() + rand(-1,1), $creature->getY() + rand(-1,1));
            $creatureCreationRepository->save($newCreature);

            echo "Added new creature! [" . $newCreature->getX() . "," . $newCreature->getY() . "]\n";
        }

        sleep(5);
    }
}
