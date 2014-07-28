<?php

namespace Instinct;

use Instinct\ChromosomePair;

class ReproductionChromosome extends ChromosomePair
{
    public function __construct($geneSequence)
    {
        parent::__construct('reproduce', $geneSequence);
    }

    public function getValue()
    {
        $geneSets = array(
            array('probability' => -5, 'dominant' => false),
            array('probability' => -10, 'dominant' => true),
            array('probability' => +8, 'dominant' => true),
            array('probability' => +2, 'dominant' => false),
            array('probability' => -4, 'dominant' => true),
            array('probability' => +7, 'dominant' => false),
        );

        $likelihood = 15;
        foreach ($geneSets as $setIndex => $gene) {
            if ($this->geneIsOn($setIndex, $gene['dominant'])) {
                $likelihood += $gene['probability'];
            }
        }

        return $likelihood;
    }
}
