<?php

namespace App\Converter\Exception;

use Symfony\Component\HttpFoundation\Response;

class TemperatureBelowAbsoluteZeroException extends \Exception
{
    public function __construct(\Throwable $previous = null)
    {
        parent::__construct('temperature_below_absolute_zero', Response::HTTP_UNPROCESSABLE_ENTITY, $previous);
    }
}
