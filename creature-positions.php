<?php

require_once 'Creature.php';
require_once 'ChromosomePair.php';
require_once 'ColorChromosome.php';

require_once 'MongoCreatureRepository.php';

$creatureCollection = (new \MongoClient())->instinctdb->creature;
$creatureRepository = new MongoCreatureRepository($creatureCollection);

$creature = $creatureRepository->findOneById(1);

echo json_encode(array($creature->toArray()));
