<?php

require_once 'vendor/autoload.php';

use Instinct\MongoCreatureRepository;

$creatureCollection = (new \MongoClient())->instinctdb->creature;
$creatureRepository = new MongoCreatureRepository($creatureCollection);

$creatures = $creatureRepository->find();

$flatCreatures = array();
foreach ($creatures as $creature) {
    $flatCreatures[] = $creature->toArray();
}

header("Content-Type: application/json");
echo json_encode($flatCreatures);
