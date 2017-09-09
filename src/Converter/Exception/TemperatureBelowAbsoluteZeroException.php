<?php

namespace Converter\Exception;

class TemperatureBelowAbsoluteZeroException extends \Exception
{
    public function __construct(\Throwable $previous = null)
    {
        parent::__construct('temperature_below_absolute_zero', 0, $previous);
    }
}
