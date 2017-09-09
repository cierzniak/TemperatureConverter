<?php

namespace App\Converter\Service;

use App\Converter\Model\Temperature;
use App\Converter\Model\TemperatureUnit;

class TemperatureConverter
{
    public function convert(Temperature $fromTemperature, TemperatureUnit $toUnit)
    {
        if ($fromTemperature->unit()->isSameUnit($toUnit)) {
            return $fromTemperature;
        }
        $value = $fromTemperature->value();
        if (!$fromTemperature->unit()->isSameUnit(new TemperatureUnit('K'))) {
            $value = $this->calculateToKelvin($fromTemperature->unit(), $value);
        }
        if (!$toUnit->isSameUnit(new TemperatureUnit('K'))) {
            $value = $this->calculateFromKelvin($toUnit, $value);
        }

        return new Temperature($value, $toUnit);
    }

    private function calculateToKelvin(TemperatureUnit $fromUnit, float $value)
    {
        $rates = [
            'C' => $value + 273.15,
            'F' => ($value + 459.67) * 5 / 9,
        ];

        return $rates[$fromUnit->unit()];
    }

    private function calculateFromKelvin(TemperatureUnit $toUnit, float $value)
    {
        $rates = [
            'C' => $value - 273.15,
            'F' => $value * 9 / 5 - 459.67,
        ];

        return $rates[$toUnit->unit()];
    }
}
