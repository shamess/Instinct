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

    public function findSurroundingByXY($x, $y)
    {
        $surrounding = array();

        for($xDiff = -1; $xDiff <= 1; $xDiff++) {
            for($yDiff = -1; $yDiff <= 1; $yDiff++) {
                if ($yDiff === 0 && $xDiff === 0) {
                    continue;
                }

                if (!$this->isWithinBounds($x + $xDiff, $y + $yDiff)) {
                    continue;
                }

                $surrounding[] = $this->findByXY($x + $xDiff, $y + $yDiff);
            }
        }

        return $surrounding;
    }

    private function assertWithinBounds($x, $y)
    {
        if (false === $this->isWithinBounds($x, $y)) {
            throw new \OutOfBoundsException();
        }
    }

    private function isWithinBounds($x, $y)
    {
        return ($x >= 0 && $x <= 11 && $y >= 0 && $y <= 11);
    }
}
