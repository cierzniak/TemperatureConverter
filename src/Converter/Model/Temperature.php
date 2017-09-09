<?php

namespace Converter\Model;

class Temperature
{
    private $value;
    private $unit;

    public function __construct(float $value, TemperatureUnit $unit)
    {
        $this->value = $value;
        $this->unit = $unit;
    }

    public function value(): float
    {
        return $this->value;
    }

    public function unit(): TemperatureUnit
    {
        return $this->unit;
    }
}
