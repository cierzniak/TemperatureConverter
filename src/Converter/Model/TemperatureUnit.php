<?php

namespace Converter\Model;

use Converter\Exception\UnsupportedTemperatureUnitException;

class TemperatureUnit
{
    private const SUPPORTED_UNITS = ['C', 'F', 'K'];

    private $unit;

    public function __construct(string $unit)
    {
        if (!$this->isSupportedUnit($unit)) {
            throw new UnsupportedTemperatureUnitException();
        }
        $this->unit = $unit;
    }

    public function unit(): string
    {
        return $this->unit;
    }

    public function isSameUnit(self $other): bool
    {
        return $this->unit() === $other->unit();
    }

    private function isSupportedUnit(string $scale): bool
    {
        return \in_array(\strtoupper($scale), self::SUPPORTED_UNITS);
    }
}
