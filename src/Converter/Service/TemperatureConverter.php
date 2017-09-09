<?php

namespace Converter\Service;

use Converter\Model\Temperature;
use Converter\Model\TemperatureUnit;

class TemperatureConverter
{
    public function convert(Temperature $fromTemperature, TemperatureUnit $toUnit)
    {
        return $fromTemperature;
    }
}
