<?php

namespace Converter\Model;

use Converter\Exception\UnsupportedTemperatureUnitException;

class TemperatureUnit
{
    private const SUPPORTED_UNITS = ['C', 'F', 'K'];

    private $unit;

    public function __construct(string $unit)
    {
        $this->unit = strtoupper($unit);
        if (!$this->isSupportedUnit()) {
            throw new UnsupportedTemperatureUnitException();
        }
    }

    public function unit(): string
    {
        return $this->unit;
    }

    public function isSameUnit(self $other): bool
    {
        return $this->unit() === $other->unit();
    }

    private function isSupportedUnit(): bool
    {
        return in_array($this->unit(), self::SUPPORTED_UNITS);
    }
}
