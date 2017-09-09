<?php

namespace App\Tests\Command;

use App\Command\ConverterCommand;
use App\Converter\Exception\TemperatureBelowAbsoluteZeroException;
use App\Converter\Exception\UnsupportedTemperatureUnitException;
use App\Converter\Service\TemperatureConverter;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Console\Tester\CommandTester;

class ConverterCommandTest extends KernelTestCase
{
    private const COMMAND_NAME = 'app:converter';

    /**
     * @test
     */
    public function returns_ok(): void
    {
        $commandTester = $this->prepareCommand();
        $commandTester->execute(['command' => self::COMMAND_NAME, 'value' => '100', 'unit' => 'C']);

        $output = $commandTester->getDisplay();
        $this->assertContains('Temperatura 100C w innych jednostkach ma wartość:', $output);
        $this->assertContains('* 100C', $output);
        $this->assertContains('* 212F', $output);
        $this->assertContains('* 373.15K', $output);
    }

    /**
     * @test
     */
    public function returns_unprocessable_entity_when_trying_to_convert_not_supported_unit(): void
    {
        $commandTester = $this->prepareCommand();

        $this->expectException(UnsupportedTemperatureUnitException::class);

        $commandTester->execute(['command' => self::COMMAND_NAME, 'value' => '0', 'unit' => 'x']);
    }

    /**
     * @test
     */
    public function returns_unprocessable_entity_when_trying_to_convert_value_below_absolute_zero(): void
    {
        $commandTester = $this->prepareCommand();

        $this->expectException(TemperatureBelowAbsoluteZeroException::class);

        $commandTester->execute(['command' => self::COMMAND_NAME, 'value' => '-500', 'unit' => 'c']);
    }

    private function prepareCommand(): CommandTester
    {
        $kernel = static::createKernel();
        $kernel->boot();

        $application = new Application($kernel);
        $application->add(new ConverterCommand(
            $kernel->getContainer()->get(TemperatureConverter::class),
            $kernel->getContainer()->get('translator')
        ));

        return new CommandTester($application->find(self::COMMAND_NAME));
    }
}
