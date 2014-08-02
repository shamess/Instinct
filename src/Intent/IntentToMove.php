<?php

namespace Instinct\Intent;

use Instinct\MongoWorldPositionRepository;
use Instinct\Creature\Creature;
use Instinct\WorldPosition;

/**
 * Decides how much the Creature wants to move to a location
 *
 * In this case, the creature doesn't really care and will just
 * go anywhere they're able. They've no eyes or senses to help
 * them navigate and so will attempt to move into imposible
 * places.
 *
 * It is not the Intent's job to work out if it's possible to
 * move there.
 */
class IntentToMove
{
    private $creature;

    public function __construct(Creature $creature)
    {
        $this->creature = $creature;
    }

    public function desireToMoveTo(WorldPosition $position)
    {
        if ($position->hasBulkyOccupant()) {
            return 0;
        }

        return rand(1, 100);
    }
}
