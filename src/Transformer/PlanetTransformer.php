<?php

namespace App\Transformer;

use Symfony\Component\HttpFoundation\Request;

class PlanetTransformer
{
    /**
     * @param mixed $content
     * @param Request $request
     * @return \stdClass
     */
    public function transformGetPlanet(mixed $content, Request $request): \stdClass
    {
        $response = new \stdClass();
        $response->id = (int) $request->get('id');
        $response->name = $content->name;
        $response->rotation_period = (int) $content->rotation_period;
        $response->orbital_period = (int) $content->orbital_period;
        $response->diameter = (int) $content->diameter;
        $response->films_count = count($content->films);
        $response->created = $content->created;
        $response->edited = $content->edited;
        $response->url = $request->getRequestUri();
        return $response;
    }

    public function transformPostPlanet(mixed $content, Request $request)
    {
        $response = $this->transformGetPlanet($content, $request);
        $response->created = new \DateTime(date("Y-m-d\TH:i:s.u\Z", strtotime($content->created)));
        $response->edited = new \DateTime(date("Y-m-d\TH:i:s.u\Z", strtotime($content->edited)));
        return $response;
    }
}