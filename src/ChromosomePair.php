<?php

namespace Instinct;

abstract class ChromosomePair
{
    protected $geneSequence, $geneSwitches;
    protected $name;

    public function __construct($pairName, $geneSequence)
    {
        $this->name = $pairName;
        $this->geneSequence = $geneSequence;

        $this->geneSwitches = $this->geneSequenceToArray($geneSequence);
    }

    public function getName()
    {
        return $this->name;
    }

    public function getGeneSequence()
    {
        return $this->geneSequence;
    }

    abstract public function getValue();

    protected function geneIsOn($setIndex, $dominant)
    {
        $gene = $this->geneSwitches[$setIndex];

        if ($dominant) {
            return $gene[0] || $gene[1];
        } else {
            return $gene[0] && $gene[1];
        }
    }

    private function geneSequenceToArray($geneString)
    {
        $genePairs = explode(';', $geneString);

        $geneSets = array();

        foreach ($genePairs as $pair) {
            $pair = explode(',', $pair);

            $geneSets[] = array($pair[0], $pair[1]);
        }

        return $geneSets;
    }

}
