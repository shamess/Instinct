<?php

require_once 'Creature.php';
require_once 'ChromosomePair.php';
require_once 'ColorChromosome.php';
require_once 'ReproductionChromosome.php';

require_once 'MongoCreatureRepository.php';

$creatureCollection = (new \MongoClient())->instinctdb->creature;
$creatureRepository = new MongoCreatureRepository($creatureCollection);

$creatures = $creatureRepository->find();

$flatCreatures = array();
foreach ($creatures as $creature) {
    $flatCreatures[] = $creature->toArray();
}

echo json_encode($flatCreatures);
