<?php

namespace Instinct\Tests\Creature;

use Instinct\Creature\Creature;

class CreatureTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->creature = new Creature(3, 4);
    }

    public function testXYAreReturnedUntouched()
    {
        $this->assertEquals(3, $this->creature->getX());
        $this->assertEquals(4, $this->creature->getY());
    }
}
