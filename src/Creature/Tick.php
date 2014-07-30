<?php

namespace Instinct\Creature;

/**
 * Represents a turn for the Creature; does an action.
 */
class Tick
{
    private $creature;

    public function __construct(Creature $creature)
    {
        $this->creature = $creature;
    }

    public function tick()
    {
        $this->creature->setHunger($this->creature->getHunger() - 1);
    }
}
