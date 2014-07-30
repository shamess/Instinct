<?php

namespace Instinct\Tests\Creature;

use Instinct\Creature\Tick;
use Instinct\Creature\Creature;

class TickTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->creature = new Creature(3, 4);
        $this->tick = new Tick($this->creature);
    }

    public function testTickShouldDepleteEnergy()
    {
        $currentHungerLevel = $this->creature->getHunger();

        $this->tick->tick();

        $this->assertEquals($currentHungerLevel - 1, $this->creature->getHunger());
    }
}
