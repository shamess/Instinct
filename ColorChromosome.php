<?php

class ColorChromosome extends ChromosomePair
{
    private $genesSwitches, $genesString;

    public function __construct($genes)
    {
        parent::__construct("color");

        $this->genesString = $genes;
        $this->genesSwitches = $this->geneStringToArray($genes);
    }

    public function getValue()
    {
        return $this->decideColor();
    }

    public function getGenesAsString()
    {
        return $this->genesString;
    }

    private function decideColor()
    {
        $geneSets = array(
            array('r' => 45, 'g' => 0, 'b' => -80, 'dominant' => true),
            array('r' => 0, 'g' => -70, 'b' => 13, 'dominant' => false),
            array('r' => 0, 'g' => 10, 'b' => 50, 'dominant' => false),
            array('r' => -40, 'g' => 10, 'b' => 70, 'dominant' => true),
            array('r' => 0, 'g' => 30, 'b' => -25, 'dominant' => false),
            array('r' => -20, 'g' => 60, 'b' => 25, 'dominant' => false),
            array('r' => 54, 'g' => 130, 'b' => 55, 'dominant' => true),
            array('r' => -12, 'g' => 42, 'b' => -25, 'dominant' => true),
        );

        $rgbValues = array('r' => 160, 'g' => 100, 'b' => 145);
        foreach ($geneSets as $setIndex => $gene) {
            if ($this->geneIsOn($setIndex, $gene['dominant'])) {
                $rgbValues['r'] += $gene['r'];
                $rgbValues['g'] += $gene['g'];
                $rgbValues['b'] += $gene['b'];
            }
        }

        return $rgbValues;
    }

    private function geneIsOn($setIndex, $dominant)
    {
        $gene = $this->genesSwitches[$setIndex];

        if ($dominant) {
            return $gene[0] || $gene[1];
        } else {
            return $gene[0] && $gene[1];
        }
    }
}
