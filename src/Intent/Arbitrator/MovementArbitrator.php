<?php

namespace Instinct\Intent\Arbitrator;

use Instinct\Creature\Creature;
use Instinct\MongoWorldPositionRepository;
use Instinct\Intent\IntentToMove;

/**
 * Given that there's a number of places the Creature may want to move. This 
 * decides the one it wants the most.
 */
class MovementArbitrator
{
    private $creature;

    public function __construct(Creature $creature, MongoWorldPositionRepository $worldPositions)
    {
        $this->creature = $creature;

        $this->surroundingPositions = $worldPositions->findSurroundingByXY($creature->getX(), $creature->getY());
        $this->intentToMove = new IntentToMove($this->creature);
    }

    public function getPositionToMoveTo()
    {
        $intentions = array();

        foreach ($this->surroundingPositions as $position) {
            $intent = $this->intentToMove->desireToMoveTo($position);

            if ($intent === 0) {
                continue;
            }

            $intentions[] = array('strength' => $intent, 'position' => $position);
        }

        $highestIntent = array('strength' => 0, 'position' => null);
        foreach ($intentions as $intent) {
            if ($highestIntent['strength'] >= $intent['strength']) {
                continue;
            }

            $highestIntent = $intent;
        }

        return $highestIntent['position'];
    }
}
