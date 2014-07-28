<?php

namespace Instinct;

class WorldPosition
{
    private $bulky = null;

    private $x, $y;

    public function __construct($x, $y)
    {
        $this->x = $x;
        $this->y = $y;
    }

    public function getX()
    {
        return $this->x;
    }

    public function getY()
    {
        return $this->y;
    }

    public function setBulkyOccupant($occupant)
    {
        $this->bulky = $occupant;
    }

    public function hasBulkyOccupant()
    {
        return (bool) $this->bulky;
    }
}
