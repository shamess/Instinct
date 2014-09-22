<?php

namespace Instinct\Plant;

class Plant
{
    private $id;
    private $x, $y;

    public function __construct($x, $y)
    {
        $this->setX($x);
        $this->setY($y);
    }

    public function getX()
    {
        return $this->x;
    }

    public function setX($x)
    {
        $this->x = $x;
    }

    public function getY()
    {
        return $this->y;
    }

    public function setY($y)
    {
        $this->y = $y;
    }

    public function isAlive()
    {
        return true;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getId()
    {
        return $this->id;
    }

    public function toArray()
    {
        return array(
            'x' => $this->getX(),
            'y' => $this->getY(),
            'alive' => $this->isAlive(),
            'id' => $this->getId(),
        );
    }
}
