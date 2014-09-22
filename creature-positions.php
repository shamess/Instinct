<?php

require_once 'vendor/autoload.php';

use Instinct\MongoCreatureRepository;
use Instinct\Plant\MongoPlantRepository;

$mongo = new \MongoClient();

$creatureCollection = $mongo->instinctdb->creature;
$creatureRepository = new MongoCreatureRepository($creatureCollection);

$creatures = $creatureRepository->find();

$flatCreatures = array();
foreach ($creatures as $creature) {
    $flatCreatures[] = $creature->toArray();
}

$plantCollection = $mongo->instinctdb->plant;
$plantRepository = new MongoPlantRepository($plantCollection);

$plants = $plantRepository->find();

$flatPlants = array();
foreach ($plants as $plant) {
    $flatPlants[] = $plant->toArray();
}

$forClientToRender = array(
    'creatures' => $flatCreatures,
    'plants' => $flatPlants,
);

header("Content-Type: application/json");
echo json_encode($forClientToRender);
