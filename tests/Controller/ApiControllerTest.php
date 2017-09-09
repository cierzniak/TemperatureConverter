<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class ApiControllerTest extends WebTestCase
{
    /**
     * @test
     */
    public function returns_ok(): void
    {
        $client = static::createClient();

        $client->request('GET', '/api/v1/converter/c/-273.15');
        $content = json_decode($client->getResponse()->getContent());

        $this->assertEquals(Response::HTTP_OK, $client->getResponse()->getStatusCode());
        $this->assertTrue(in_array('C', array_keys((array) $content->data->entered)));
        $this->assertEquals(-273.15, $content->data->entered->C);
        $this->assertTrue(in_array('K', array_keys((array) $content->data->converted)));
        $this->assertEquals(0, $content->data->converted->K);
        $this->assertTrue(in_array('C', array_keys((array) $content->data->converted)));
        $this->assertEquals(-273.15, $content->data->converted->C);
        $this->assertTrue(in_array('F', array_keys((array) $content->data->converted)));
        $this->assertEquals(-459.67, $content->data->converted->F);
    }

    /**
     * @test
     */
    public function returns_unprocessable_entity_when_trying_to_convert_not_supported_unit(): void
    {
        $client = static::createClient();

        $client->request('GET', '/api/v1/converter/x/0');
        $content = json_decode($client->getResponse()->getContent());

        $this->assertEquals(Response::HTTP_UNPROCESSABLE_ENTITY, $client->getResponse()->getStatusCode());
        $this->assertEquals('Niewspierany format temperatury.', $content->error->message);
    }

    /**
     * @test
     */
    public function returns_unprocessable_entity_when_trying_to_convert_value_below_absolute_zero(): void
    {
        $client = static::createClient();

        $client->request('GET', '/api/v1/converter/f/-500');
        $content = json_decode($client->getResponse()->getContent());

        $this->assertEquals(Response::HTTP_UNPROCESSABLE_ENTITY, $client->getResponse()->getStatusCode());
        $this->assertEquals('Temperatura poniżej zera absolutnego.', $content->error->message);
    }
}
