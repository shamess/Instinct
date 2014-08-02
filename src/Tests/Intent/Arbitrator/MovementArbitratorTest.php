<?php

namespace Instinct\Tests\Intent\Arbitrator;

use Instinct\Intent\Arbitrator\MovementArbitrator;
use Instinct\Creature\Creature;
use Instinct\WorldPosition;
use Mockery as m;

class MovementArbitratorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var MovementArbitrator
     */
    private $arbitrator;

    public function setUp()
    {
        $creature = new Creature(4, 3);

        $this->worldPositions = m::mock('Instinct\MongoWorldPositionRepository');

        $positions = array(
            new WorldPosition(3, 3),
            new WorldPosition(3, 4),
        );

        $this->worldPositions
            ->shouldReceive('findSurroundingByXY')
            ->once()
            ->with(4, 3)
            ->andReturn($positions);

        $this->arbitrator = new MovementArbitrator($creature, $this->worldPositions);
    }

    public function testGetPositionToMoveToReturnsWorldPosition()
    {
        $position = $this->arbitrator->getPositionToMoveTo();

        $this->assertInstanceOf('Instinct\WorldPosition', $position);
        $this->assertEquals(3, $position->getX());
    }
}
