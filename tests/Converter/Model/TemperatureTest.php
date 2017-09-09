<?php

namespace Tests\Converter\Model;

use Converter\Exception\TemperatureBelowAbsoluteZeroException;
use Converter\Model\Temperature;
use Converter\Model\TemperatureUnit;
use PHPUnit\Framework\TestCase;

class TemperatureTest extends TestCase
{
    /**
     * @test
     */
    public function returns_temperature_object(): void
    {
        $temperature = new Temperature(0, new TemperatureUnit('K'));

        $this->assertEquals(new Temperature(0, new TemperatureUnit('K')), $temperature);
    }

    /**
     * @test
     */
    public function throws_temperature_below_absolute_zero_exception(): void
    {
        $this->expectException(TemperatureBelowAbsoluteZeroException::class);

        new Temperature(-1, new TemperatureUnit('K'));
    }
}
