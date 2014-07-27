<?php

abstract class ChromosomePair
{
    private $name;

    public function __construct($pairName)
    {
        $this->name = $pairName;
    }

    public function getName()
    {
        return $this->name;
    }

    protected function geneStringToArray($geneString)
    {
        $genePairs = explode(';', $geneString);

        $geneSets = array();

        foreach ($genePairs as $pair) {
            $pair = explode(',', $pair);

            $geneSets[] = array($pair[0], $pair[1]);
        }

        return $geneSets;
    }

    abstract public function getValue();
    abstract public function getGenesAsString();
}
