<?php

require_once 'Creature.php';
require_once 'ChromosomePair.php';
require_once 'ColorChromosome.php';
require_once 'ReproductionChromosome.php';

require_once 'MongoCreatureRepository.php';
require_once 'MongoCreatureCreationRepository.php';

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
