<?php

namespace Instinct\Tests\Intent;

use Instinct\Intent\IntentToMove;
use Instinct\Creature\Creature;
use Instinct\WorldPosition;

class IntentToMoveTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $creature = new Creature(5, 4);

        $this->intent = new IntentToMove($creature);
    }

    public function testDesireToMoveToReturnsValue()
    {
        $position = new WorldPosition(4, 4);

        $this->assertGreaterThan(0, $this->intent->desireToMoveTo($position));
    }

    public function testDoesntAttemptToMoveIntoOccupiedPosition()
    {
        $position = new WorldPosition(4, 4);
        $position->setBulkyOccupant(new Creature(4, 4));

        $this->assertEquals(0, $this->intent->desireToMoveTo($position));
    }
}
