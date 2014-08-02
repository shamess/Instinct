<?php

namespace Instinct\Tests;

use Mockery as m;
use Instinct\MongoWorldPositionRepository;
use Instinct\Creature\Creature;

class MongoWorldPositionRepositoryTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->creature = new Creature(3, 4);

        $creatures = m::mock('\MongoCollection');
        $creatures
            ->shouldReceive('findOne')
            ->with(array('x' => 5, 'y' => 5))
            ->andReturn(null);
        $creatures
            ->shouldReceive('findOne')
            ->with(array('x' => 3, 'y' => 4))
            ->andReturn($this->creature);

        $this->repo = new MongoWorldPositionRepository($creatures);
    }

    /**
     * @dataProvider provideInvalidCoords
     */
    public function testGetsUpsetWhenOutOfBounds($x, $y)
    {
        $this->setExpectedException("\OutOfBoundsException");

        $this->repo->findByXY($x, $y);
    }

    public function provideInvalidCoords()
    {
        return array(
            array(5, 12),
            array(12, 9),
            array(99, 23),
            array(-2, 7),
            array(-2, 13),
        );
    }

    public function testReturnsWorldPositionWithBulkyOccupant()
    {
        $this->assertTrue($this->repo->findByXY(3, 4)->hasBulkyOccupant());
    }

    public function testReturnsNotBulkyPosition()
    {
        $this->assertFalse($this->repo->findByXY(5, 5)->hasBulkyOccupant());
    }

    public function testAllSurroundingAreasAreChecking()
    {
        $creatures = m::mock('\MongoCollection');
        $creatures
            ->shouldReceive('findOne')
            ->with(array('x' => 5, 'y' => 5))
            ->never();

        $creatures
            ->shouldReceive('findOne')
            ->with(array('x' => 4, 'y' => 5))
            ->once();

        $creatures
            ->shouldReceive('findOne')
            ->with(array('x' => 4, 'y' => 4))
            ->once();

        $creatures
            ->shouldReceive('findOne')
            ->with(array('x' => 6, 'y' => 6))
            ->once();

        $creatures
            ->shouldReceive('findOne');

        $this->repo = new MongoWorldPositionRepository($creatures);

        $this->repo->findSurroundingByXY(5, 5);
    }

    protected function tearDown() {
        m::close();
    }
}
