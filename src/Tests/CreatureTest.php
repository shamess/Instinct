<?php

namespace Instinct\Test;

use Instinct\Creature;

class CreatureTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->creature = new Creature(3, 4);
    }

    public function testTickDecreasesHunger()
    {
        $this->creature->setHunger(5);

        $this->creature->tick();

        $this->assertEquals(4, $this->creature->getHunger());
    }
}
