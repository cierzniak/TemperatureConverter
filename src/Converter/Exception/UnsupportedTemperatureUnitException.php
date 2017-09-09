<?php

namespace App\Converter\Exception;

use Symfony\Component\HttpFoundation\Response;

class UnsupportedTemperatureUnitException extends \Exception
{
    public function __construct(\Throwable $previous = null)
    {
        parent::__construct('unsupported_temperature_unit', Response::HTTP_UNPROCESSABLE_ENTITY, $previous);
    }
}
