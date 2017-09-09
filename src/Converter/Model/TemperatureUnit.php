<?php

namespace Converter\Model;

class TemperatureUnit
{
    private $unit;

    public function __construct(string $unit)
    {
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
}
