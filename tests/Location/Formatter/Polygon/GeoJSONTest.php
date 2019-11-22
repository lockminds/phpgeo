<?php
declare(strict_types=1);

namespace Location\Formatter\Polygon;

use Location\Coordinate;
use Location\Polygon;

use PHPUnit\Framework\TestCase;

class GeoJSONTest extends TestCase
{
    /**
     * @var GeoJSON
     */
    protected $formatter;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->formatter = new GeoJSON();
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {
        unset($this->formatter);
    }

    public function testFormatDefault()
    {
        $polygon = new Polygon();
        $polygon->addPoint(new Coordinate(10, 20));
        $polygon->addPoint(new Coordinate(20, 40));
        $polygon->addPoint(new Coordinate(30, 40));
        $polygon->addPoint(new Coordinate(30, 20));

        $json = '{ "type" : "Polygon" , "coordinates" : [ [ [ 20, 10 ], [ 40, 20 ], [ 40, 30 ], [ 20, 30] ] ] }';

        $this->assertJsonStringEqualsJsonString($json, $this->formatter->format($polygon));
    }

    /**
     * @expectedException \Location\Exception\InvalidPolygonException
     */
    public function testPolygonGeoJSONWithLessThanThreePointsThrowsInvalidPolygonException()
    {
        $polygon = new Polygon();
        $polygon->addPoint(new Coordinate(0, 0));
        $polygon->addPoint(new Coordinate(10, 10));

        $this->formatter->format($polygon);
    }
}
