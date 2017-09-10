<?php

namespace App\Controller;

use App\Converter\Model\Temperature;
use App\Converter\Model\TemperatureUnit;
use App\Converter\Service\TemperatureConverter;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class ApiController extends Controller
{
    private $converterService;

    public function __construct(TemperatureConverter $converterService)
    {
        $this->converterService = $converterService;
    }

    public function converter(string $unit, float $value)
    {
        $temperature = new Temperature($value, new TemperatureUnit($unit));
        $data = ['entered' => [$temperature->unit()->unit() => $temperature->value()]];
        foreach (TemperatureUnit::SUPPORTED_UNITS as $unit) {
            $data['converted'][$unit] = $this->converterService
                ->convert($temperature, new TemperatureUnit($unit))
                ->value();
        }

        return $this->json(compact('data'), Response::HTTP_OK);
    }
}
