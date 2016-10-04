<?php

namespace UserBundle\Security;

use Symfony\Component\DependencyInjection\ContainerInterface as Container;
use Symfony\Component\Routing\Router;

class GoogleService
{
    protected $container;
    protected $router;
    protected $redirectRouteName = 'google_check';
    protected $scopes = ['email', 'profile'];

    public function __construct(Router $router, Container $container)
    {
        $this->router = $router;
        $this->container = $container;
    }

    public function init()
    {
        // 704118661131-33bh0uukfro8o3ne5c727cd5bo9nljln.apps.googleusercontent.com
        // gUVeePzKyw6ZSFd6tygTAyX3
        $client = new \Google_Client( //TODO Hide id and secret
            [
                'client_id' => "375709262973-g7q7p85bh2qk0ieddmafm665sqf71rek.apps.googleusercontent.com",//$this->container->getParameter('google_client_id'),
                'client_secret' => "OYvnMHoW712hJrRS3fGV_gYy"//$this->container->getParameter('google_client_secret'),
            ]
        );
        $client->setRedirectUri($this->generateRedirectUrl());
        $client->setScopes($this->scopes);
        return $client;
    }

    protected function generateRedirectUrl()
    {
        return $this->router->generate($this->redirectRouteName, [], true);
    }
}