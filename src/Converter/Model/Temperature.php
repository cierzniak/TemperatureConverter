<?php

namespace Converter\Model;

use Converter\Exception\TemperatureBelowAbsoluteZeroException;

class Temperature
{
    private const ABSOLUTE_ZERO_TEMPERATURE = [
        'K' => 0,
        'C' => -273.15,
        'F' => -459.67,
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
