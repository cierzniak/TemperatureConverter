<?php

namespace Tests\Converter;

use Converter\Exception\UnsupportedTemperatureUnitException;
use Converter\Model\Temperature;
use Converter\Model\TemperatureUnit;
use Converter\Service\TemperatureConverter;
use PHPUnit\Framework\TestCase;

class ConverterTest extends TestCase
{
    /**
     * @test
     */
    public function returns_equal_temperature_if_converting_temperature_with_the_same_unit(): void
    {
        $converter = new TemperatureConverter();

        $convertedTemperature = $converter->convert(new Temperature(36.6, new TemperatureUnit('C')), new TemperatureUnit('C'));
        $this->assertEquals(new Temperature(36.6, new TemperatureUnit('C')), $convertedTemperature);
    }

    /**
     * @test
     * @dataProvider different_units
     *
     * @param float  $value
     * @param string $from
     * @param string $to
     * @param float  $result
     */
    public function returns_converted_temperature_if_converting_with_different_units(float $value, string $from, string $to, float $result): void
    {
        $converter = new TemperatureConverter();

        $convertedTemperature = $converter->convert(new Temperature($value, new TemperatureUnit($from)), new TemperatureUnit($to));
        $this->assertEquals(new Temperature($result, new TemperatureUnit($to)), $convertedTemperature);
    }

    /**
     * @return array
     */
    public function different_units()
    {
        return [
            '0K to C' => [0, 'K', 'C', -273.15],
            '0K to F' => [0, 'K', 'F', -459.67],
            '-100C to K' => [-100, 'C', 'K', 173.15],
            '-100C to F' => [-100, 'C', 'F', -148],
            '30F to K' => [30, 'F', 'K', 272.0388888888889],
            '30F to C' => [30, 'F', 'C', -1.1111111111110858],
        ];
    }

    /**
     * @test
     */
    public function throws_unsupported_unit_exception_if_converting_from_unsupported_unit(): void
    {
        $converter = new TemperatureConverter();

        $this->expectException(UnsupportedTemperatureUnitException::class);

        $converter->convert(new Temperature(36.6, new TemperatureUnit('X')), new TemperatureUnit('C'));
    }

    /**
     * @test
     */
    public function throws_unsupported_unit_exception_if_converting_to_unsupported_unit(): void
    {
        $converter = new TemperatureConverter();

        $this->expectException(UnsupportedTemperatureUnitException::class);

        $converter->convert(new Temperature(36.6, new TemperatureUnit('C')), new TemperatureUnit('X'));
    }
}
