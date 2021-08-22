<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PlanetControllerTest extends WebTestCase
{
    public function testGetPlanets(): void
    {
        $responseParams = array(
            'id',
            'name',
            'rotation_period',
            'orbital_period',
            'diameter',
            'films_count',
            'created',
            'edited',
            'url'
        );
        $client = static::createClient();
        $client->request('GET', '/planets/1');
        $content = json_decode($client->getResponse()->getContent());
        $this->assertResponseIsSuccessful();
        $this->assertEquals('Tatooine', $content->name);
        foreach ($responseParams as $responseParam) {
            $this->assertObjectHasAttribute($responseParam, $content);
        }
    }

    public function testPostPlanets(): void
    {
        $client = static::createClient();
        $params = array(
            'id' => 1,
            'name' => ''
        );
        $response = $client->request('POST', '/planet');
        var_dump($client->getResponse());
    }
}