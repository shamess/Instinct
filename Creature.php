<?php

class Creature
{
    private $x, $y, $id;

    private $chromosomePairs = array();

    public function __construct($id, $x, $y)
    {
        $this->x = $x;
        $this->y = $y;

        $this->id = $id;
    }

    public function getColor()
    {
        $color = $this->getChromosomePair('color');

        if ($color) {
            return $color->getValue();
        }

        return '#FFF';
    }

    public function addToGenome(ChromosomePair $chromosomePair)
    {
        $this->chromosomePairs[$chromosomePair->getName()] = $chromosomePair;
    }

    private function getChromosomePair($pairName)
    {
        return array_key_exists($pairName, $this->chromosomePairs) ?
            $this->chromosomePairs[$pairName] : null;
    }

    public function toArray()
    {
        return array(
            'x' => $this->x,
            'y' => $this->y,
            'id' => $this->id,

            'color' => $this->getColor(),
        );
    }
}
