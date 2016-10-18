<?php

namespace UserBundle\Security;

use Symfony\Component\DependencyInjection\ContainerInterface as Container;
use Symfony\Component\HttpFoundation\RequestStack;

class GoogleOAuth
{
    protected $container;
    protected $request;
    protected $client;
    protected $domains = ['npu.edu.ua', 'std.npu.edu.ua'];

    public function __construct(GoogleService $client, Container $container, RequestStack $requestStack)
    {
        $this->client = $client->init();
        $this->container = $container;
        $this->request = $requestStack->getCurrentRequest();
    }

    public function getClient()
    {
        return $this->client;
    }

    public function getAuthUrl()
    {
        return $this->client->createAuthUrl();
    }

    public function getResponse()
    {
        $code = $this->request->query->get('code');
        if (!$code) {
            return false;
        }
        $token = $this->client->fetchAccessTokenWithAuthCode($code);
        $this->client->setAccessToken($token);
        $oauthService = new \Google_Service_Oauth2($this->client);
        $response = $oauthService->userinfo->get();
        return $this->checkDomain($response);
    }

    /**
     * @param \Google_Service_Oauth2_Userinfoplus $response
     * @return mixed
     */
    public function checkDomain($response)
    {
        if ($response->getHd() && in_array($response->getHd(), $this->domains)) {
            return $response;
        }
        return false;
    }
}