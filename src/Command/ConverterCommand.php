<?php

namespace App\Command;

use App\Converter\Model\Temperature;
use App\Converter\Model\TemperatureUnit;
use App\Converter\Service\TemperatureConverter;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Translation\TranslatorInterface;

class ConverterCommand extends Command
{
    private $converterService;
    private $translator;

    public function __construct(TemperatureConverter $converterService, TranslatorInterface $translator)
    {
        parent::__construct();
        $this->converterService = $converterService;
        $this->translator = $translator;
    }

    protected function configure(): void
    {
        $this->setName('app:converter')
            ->setDescription('Converts temperatures')
            ->setHelp('This command allows you to convert entered temperature to all other supported units')
            ->addArgument('value', InputArgument::REQUIRED, 'Temperature value you want to convert')
            ->addArgument('unit', InputArgument::REQUIRED, 'Temperature unit you want to convert');
    }

    protected function execute(InputInterface $input, OutputInterface $output): void
    {
        $temperature = new Temperature($input->getArgument('value'), new TemperatureUnit($input->getArgument('unit')));
        $output->writeln($this->translator->trans('command.converter', [
            '%value%' => $temperature->value(),
            '%unit%' => $temperature->unit()->unit(),
        ]));
        foreach (TemperatureUnit::SUPPORTED_UNITS as $unit) {
            $converted = $this->converterService->convert($temperature, new TemperatureUnit($unit))->value();
            $output->writeln("* {$converted}{$unit}");
        }
    }
}
