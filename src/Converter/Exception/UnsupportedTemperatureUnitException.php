<?php

namespace Converter\Exception;

class UnsupportedTemperatureUnitException extends \Exception
{
    public function __construct(\Throwable $previous = null)
    {
        parent::__construct('unsupported_temperature_unit', 0, $previous);
    }
}
