<?php

namespace Rating\UserBundle\Security;

use Rating\UserBundle\Entity\User;
use Symfony\Component\DependencyInjection\ContainerInterface as Container;
use Symfony\Component\Routing\Router;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;

class UserManager
{
    protected $container;

    public function __construct(Container $container)
    {
        $this->container    = $container;
    }

    public function createStudent($response)
    {
        $user = $this->create($response);
        $user->addRole('ROLE_STUDENT');
        return $user;
    }
    public function createTeacher($response)
    {
        $user = $this->create($response);
        $user->addRole('ROLE_TEACHER');
        return $user;
    }
    protected function create($response)
    {
        $user = new User();
        $user->setLastName($response->getGivenName());
        $user->setFirstName($response->getFamilyName());
        $user->setGoogleId($response->getId());
        $user->setEmail($response->getEmail());
        $user->setPicture($response->getPicture());
        $user->addRole('ROLE_USER');
        $user->addRole('ROLE_ADMIN');
        return $user;
    }

    public function update($user, $response)
    {
        $user->setPicture($response->getPicture());
    }

    public function authorize($user, $request)
    {
        $token = new UsernamePasswordToken($user, null, "main", $user->getRoles());
        $this->container->get("security.token_storage")->setToken($token);
        $event = new InteractiveLoginEvent($request, $token);
        $this->container->get("event_dispatcher")->dispatch("security.interactive_login", $event);
    }
}