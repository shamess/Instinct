<?php

require_once 'Creature.php';
require_once 'ChromosomePair.php';
require_once 'ColorChromosome.php';

$color = new ColorChromosome("0,1;1,1;0,1;0,1;1,1;0,0;1,1;1,0");

$creature = new Creature(29, 5, 2);
$creature->addToGenome($color);

echo json_encode(array($creature->toArray()));
