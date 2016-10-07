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
        $client = new \Google_Client(
            [
                'client_id' => $this->container->getParameter('google_client_id'),
                'client_secret' => $this->container->getParameter('google_client_secret'),
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