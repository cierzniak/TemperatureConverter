<?php

namespace App\Converter\Model;

use App\Converter\Exception\TemperatureBelowAbsoluteZeroException;

class Temperature
{
    public const KELVIN_TO_CELSIUS_CONST = 273.15;
    public const KELVIN_TO_FAHRENHEIT_CONST = 459.67;
    public const KELVIN_TO_FAHRENHEIT_RATE = 9 / 5;
    private const ABSOLUTE_ZERO_TEMPERATURE = [
        'K' => 0,
        'C' => -1 * self::KELVIN_TO_CELSIUS_CONST,
        'F' => -1 * self::KELVIN_TO_FAHRENHEIT_CONST,
    ];

    private $value;
    private $unit;

    public function __construct(float $value, TemperatureUnit $unit)
    {
        $this->value = $value;
        $this->unit = $unit;
        if (!$this->isTemperatureAboveAbsoluteZero()) {
            throw new TemperatureBelowAbsoluteZeroException();
        }
    }

    public function value(): float
    {
        return $this->value;
    }

    public function unit(): TemperatureUnit
    {
        return $this->unit;
    }

    private function isTemperatureAboveAbsoluteZero(): bool
    {
        $absoluteZero = self::ABSOLUTE_ZERO_TEMPERATURE[$this->unit()->unit()];

        return $this->value() >= $absoluteZero;
    }
}
