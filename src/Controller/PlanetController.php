<?php

namespace App\Controller;

use App\Transformer\PlanetTransformer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class PlanetController extends AbstractController
{
    public function __construct(
        private HttpClientInterface $client,
        private PlanetTransformer $transformer
    )
    {
    }

    #[Route(
        '/planets/{id}',
        name: 'get_planets',
        requirements: [
            'id' => '\d+'
        ],
        methods: ['GET']
    )]
    public function getPlanets($id, Request $request): Response
    {
        $response = $this->client->request(
            'GET',
            $this->getParameter('planet.url') . '/planets/' . $id,
        );
        $content = json_decode($response->getContent(false));
        $response = $this->transformer->transformGetPlanet($content, $request);
        return $this->json($response);
    }

    #[Route(
        '/planet',
        name: 'post_planet',
        requirements: [
            'id' => '\d+',
            'name' => '^[a-zA-Z]+',
            'rotation_period' => '\d*',
            'orbital_period' => '\d*',
            'diameter' => '\d*'
        ],
        methods: ['POST']
    )]
    public function postPlanet(): Response
    {

    }

}
