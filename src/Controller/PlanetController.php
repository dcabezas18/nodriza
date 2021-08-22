<?php

namespace App\Controller;

use App\Entity\Planet;
use App\Transformer\PlanetTransformer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;
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
        $requestResponse = $this->getRequest($id);
        $content = json_decode($requestResponse->getContent());
        if ($requestResponse->getStatusCode() == 200) {
            $response = $this->transformer->transformGetPlanet($content, $request);
            return $this->json(['success' => true, 'data' => $response]);
        }
        throw new HttpException(
            $requestResponse->getStatusCode(),
            $content->detail
        );
    }

    #[Route(
        '/planet',
        name: 'post_planet',
        methods: ['POST']
    )]
    public function postPlanet(Request $request, ValidatorInterface $validator): Response
    {
        $planetExist = $this->getDoctrine()
            ->getRepository(Planet::class)
            ->find($request->get('id'));
        if (!$planetExist) {
            $requestResponse = $this->getRequest($request->get('id'));
            $content = json_decode($requestResponse->getContent(false));
            $dataToSave = $this->transformer->transformPostPlanet($content, $request);
            $entityManager = $this->getDoctrine()->getManager();
            $planet = new Planet();
            $this->dynamicSetter($dataToSave, $planet);
            $entityManager->persist($planet);
            $entityManager->flush();
            $response = $this->transformer->transformGetPlanet($content, $request);
            return $this->json(['success' => true, 'data' => $response], 201);
        }
        throw new HttpException(422, 'El planeta ya ha sido registrado.');
    }

    /**
     * @param $params
     * @param mixed $entity
     * @return mixed
     */
    private function dynamicSetter($params, mixed $entity): mixed
    {
        foreach ($params as $key => $param) {
            $formattedKey = str_replace(' ', '', ucfirst(str_replace('_', '', $key)));
            $function = 'set' . ucfirst($formattedKey);
            $entity->$function($param);
        }
        return $entity;
    }

    /**
     * @param $id
     * @return \Symfony\Contracts\HttpClient\ResponseInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface
     */
    public function getRequest($id)
    {
        return $this->client->request(
            'GET',
            $this->getParameter('planet.url') . '/planets/' . $id,
        );
    }
}
