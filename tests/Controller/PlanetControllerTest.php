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
        $this->assertEquals('Tatooine', $content->data->name);
        foreach ($responseParams as $responseParam) {
            $this->assertObjectHasAttribute($responseParam, $content->data);
        }
        $client->request('GET', '/planets/11111111111111');
        $content = json_decode($client->getResponse()->getContent());
        $this->assertResponseStatusCodeSame(404);
        $this->assertEquals(404, $content->errors->code);
    }

    public function testPostPlanets(): void
    {
        $client = static::createClient();
        $params = array(
            'id' => 1,
            'name' => 'Tatooine'
        );
        $client->request('POST', '/planet', $params);
        $content = json_decode($client->getResponse()->getContent());
        $this->assertResponseIsSuccessful();
        $this->assertEquals('Tatooine', $content->data->name);

        $params = array(
            'id' => 1,
            'name' => 'Tatooine'
        );
        $client->request('POST', '/planet', $params);
        $this->assertResponseStatusCodeSame(422);
    }
}