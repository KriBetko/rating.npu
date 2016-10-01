<?php
namespace System\AppBundle\Service;

use Symfony\Component\HttpFoundation\Response;

class Sender
{
    public function sendJson($data)
    {
        $response = new Response(json_encode($data));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }
}