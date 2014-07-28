<?php

require_once 'vendor/autoload.php';

use Instinct\MongoCreatureRepository;
use Instinct\MongoCreatureCreationRepository;

$client = new \MongoClient();

$creatureCollection = $client->instinctdb->creature;
$creatureRepository = new MongoCreatureRepository($creatureCollection);

$creature = $creatureRepository->findOneById(1);

if ($creature->wantsToReproduce()) {
    $counterCollection = $client->instinctdb->counters;
    $creatureCreationRepository = new MongoCreatureCreationRepository($creatureRepository, $counterCollection);

    $newCreature = $creature->reproduceByCloning($creature->getX() - 1, $creature->getY() + 1);
    $creatureCreationRepository->save($newCreature);
}
