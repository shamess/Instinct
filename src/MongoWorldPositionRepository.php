<?php

namespace Instinct;

use Instinct\WorldPosition;

class MongoWorldPositionRepository
{
    private $creatures;

    public function __construct(\MongoCollection $creatures)
    {
        $this->creatures = $creatures;
    }

    public function findByXY($x, $y)
    {
        $creatureOccupant = $this->creatures->findOne(array('x' => $x, 'y' => $y));

        $worldPosition = new WorldPosition($x, $y);
        $worldPosition->setBulkyOccupant($creatureOccupant);

        return $worldPosition;
    }
}
