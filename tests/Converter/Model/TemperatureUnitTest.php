<?php

namespace Tests\Converter\Model;

use Converter\Exception\UnsupportedTemperatureUnitException;
use Converter\Model\TemperatureUnit;
use PHPUnit\Framework\TestCase;

class TemperatureUnitTest extends TestCase
{
    /**
     * @test
     */
    public function returns_temperature_unit_object(): void
    {
        $temperatureUnit = new TemperatureUnit('K');

        $this->assertEquals(new TemperatureUnit('K'), $temperatureUnit);
    }

    /**
     * @test
     */
    public function returns_temperature_unit_object_if_entered_small_letter(): void
    {
        $temperatureUnit = new TemperatureUnit('f');

        $this->assertEquals(new TemperatureUnit('F'), $temperatureUnit);
        $this->assertEquals('F', $temperatureUnit->unit());
    }

    /**
     * @test
     */
    public function throws_unsupported_unit_exception(): void
    {
        $this->expectException(UnsupportedTemperatureUnitException::class);

        new TemperatureUnit('X');
    }
}
