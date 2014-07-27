<?php

class Creature
{
    private $x, $y;
    private $id = null;

    private $chromosomePairs = array();

    public function __construct($x, $y)
    {
        $this->x = $x;
        $this->y = $y;
    }

    public function getColor()
    {
        $color = $this->getChromosomePair('color');

        if ($color) {
            return $color->getValue();
        }

        return array('r' => 255, 'g' => 255, 'b' => 255);
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getX()
    {
        return $this->x;
    }

    public function getY()
    {
        return $this->y;
    }

    public function addToGenome(ChromosomePair $chromosomePair)
    {
        $this->chromosomePairs[$chromosomePair->getName()] = $chromosomePair;
    }

    public function reproduceByCloning($x, $y)
    {
        $newCreature = new self($x, $y);

        $newCreature->addToGenome($this->getChromosomePair('color'));

        return $newCreature;
    }

    public function toArray()
    {
        return array(
            'x' => $this->getX(),
            'y' => $this->getY(),
            'id' => $this->getId(),

            'color' => $this->getColor(),
        );
    }

    public function getChromosomePairs()
    {
        return $this->chromosomePairs;
    }

    private function getChromosomePair($pairName)
    {
        return array_key_exists($pairName, $this->chromosomePairs) ?
            $this->chromosomePairs[$pairName] : null;
    }
}
