<?php
namespace Tests\Converter;

use PHPUnit\Framework\TestCase;

class ConverterTest extends TestCase
{
    /**
     * @test
     */
    public function returns_equal_temperature_if_converting_temperature_with_the_same_unit()
    {
        $converter = new TemperatureConverter();

        $convertedTemperature = $converter->convert(new Temperature(36.6, new TemperatureUnit('C')), new TemperatureUnit('C'));
        $this->assertEquals(new Temperature(36.6, new TemperatureUnit('C')), $convertedTemperature);
    }
}
