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
        $this->assertWithinBounds($x, $y);

        $creatureOccupant = $this->creatures->findOne(array('x' => $x, 'y' => $y));

        $worldPosition = new WorldPosition($x, $y);
        $worldPosition->setBulkyOccupant($creatureOccupant);

        return $worldPosition;
    }

    private function assertWithinBounds($x, $y)
    {
        if ($x < 0 || $x >= 12 || $y < 0 || $y >= 12) {
            throw new \OutOfBoundsException();
        }
    }
}
