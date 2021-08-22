<?php

namespace App\Transformer;

use Symfony\Component\HttpFoundation\Request;

class PlanetTransformer
{
    public function transformGetPlanet(mixed $content, Request $request)
    {
        $response = new \stdClass();
        $response->id = $request->get('id');
        $response->name = $content->name;
        $response->rotation_period = $content->rotation_period;
        $response->orbital_period = $content->orbital_period;
        $response->diameter = $content->diameter;
        $response->films_count = count($content->films);
        $response->created = $content->created;
        $response->edited = $content->edited;
        $response->url = $request->getRequestUri();
        return $response;
    }
}