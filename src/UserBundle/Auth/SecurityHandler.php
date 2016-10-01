<?php

namespace UserBundle\Auth;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Router;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Http\Authentication\AuthenticationFailureHandlerInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationSuccessHandlerInterface;

class SecurityHandler implements AuthenticationSuccessHandlerInterface, AuthenticationFailureHandlerInterface
{

    private $router;

    public function __construct(Router $router)
    {
        $this->router = $router;
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token)
    {
        //dump('handler');die; TODO What?!
        $referer = $request->headers->get('referer');
        if (empty($referer)) {
            return new RedirectResponse($this->router->generate('homepage'));
        } else {
            return new RedirectResponse($referer);
        }
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
    {

        // Edit it to meet your requeriments
        //$request->getSession()->set('login_error', $error);
        return new RedirectResponse($this->router->generate('homepage'));
    }

}