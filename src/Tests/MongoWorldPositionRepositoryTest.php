<?php

namespace Instinct\Tests;

use Mockery as m;
use Instinct\MongoWorldPositionRepository;

class MongoWorldPositionRepositoryTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $collection = m::mock('\MongoCollection');

        $this->repo = new MongoWorldPositionRepository($collection);
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
}
