<?php

namespace Instinct\Tests\Creature;

use Instinct\Creature\Creature;
use Instinct\WorldPosition;

class CreatureTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->creature = new Creature(3, 4);
    }

    public function testMovingUpdatesXY()
    {
        $this->creature->move(new WorldPosition(5, 5));

        $this->assertEquals(5, $this->creature->getX());
        $this->assertEquals(5, $this->creature->getY());
    }

    public function testXYAreReturnedUntouched()
    {
        $this->assertEquals(3, $this->creature->getX());
        $this->assertEquals(4, $this->creature->getY());
    }
}
