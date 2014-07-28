<?php

namespace Instinct;

use Instinct\ChromosomePair;

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

    public function wantsToReproduce()
    {
        $likelihood = $this->getReproductionLikelihood();

        return rand(0, 100) <= $likelihood;
    }

    public function getReproductionLikelihood()
    {
        $reproduction = $this->getChromosomePair('reproduce');
        if ($reproduction === null) {
            return -1;
        }

        return $reproduction->getValue();
    }

    public function reproduceByCloning($x, $y)
    {
        $newCreature = new self($x, $y);

        foreach ($this->getChromosomePairs() as $pair) {
            $newCreature->addToGenome($pair);
        }

        return $newCreature;
    }

    public function toArray()
    {
        return array(
            'x' => $this->getX(),
            'y' => $this->getY(),
            'id' => $this->getId(),

            'color' => $this->getColor(),
            'reproduction' => $this->getReproductionLikelihood(),
        );
    }

    public function addToGenome(ChromosomePair $chromosomePair)
    {
        $this->chromosomePairs[$chromosomePair->getName()] = $chromosomePair;
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
