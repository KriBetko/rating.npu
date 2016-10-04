<?php

namespace UserBundle\Security;

use AppBundle\Entity\Year;
use Symfony\Component\DependencyInjection\ContainerInterface as Container;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;
use UserBundle\Entity\User;

class UserManager
{
    protected $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    /**
     * @param \Google_Service_Oauth2_Userinfoplus $response
     * @param Year $year
     * @return User
     */
    public function createStudent($response, $year)
    {
        $user = $this->create($response, $year);
        $user->addRole('ROLE_STUDENT');
        return $user;
    }

    /**
     * @param \Google_Service_Oauth2_Userinfoplus $response
     * @param Year $year
     * @return User
     */
    protected function create($response, $year)
    {
        $user = new User();
        $user->setLastName($response->getFamilyName());
        $user->setFirstName($response->getGivenName());
        $user->setParentName(""); //TODO ParentName not found in GoogleAccount, fix this
        $user->setGoogleId($response->getId());
        $user->setEmail($response->getEmail());
        $user->setPicture($response->getPicture());
        $user->addRole('ROLE_USER');
        $user->addRole('ROLE_ADMIN'); //TODO Delete admin role in prodServer
        $user->setAvailableYeaR($year);
        return $user;
    }

    /**
     * @param \Google_Service_Oauth2_Userinfoplus $response
     * @param Year $year
     * @return User
     */
    public function createTeacher($response, $year)
    {
        $user = $this->create($response, $year);
        $user->addRole('ROLE_TEACHER');
        return $user;
    }

    /**
     * @param User $user
     * @param \Google_Service_Oauth2_Userinfoplus $response
     */
    public function update($user, $response)
    {
        $user->setPicture($response->getPicture());
    }

    /**
     * @param User $user
     * @param $request
     */
    public function authorize($user, $request)
    {
        $token = new UsernamePasswordToken($user, null, "main", $user->getRoles());
        $this->container->get("security.token_storage")->setToken($token);
        $event = new InteractiveLoginEvent($request, $token);
        $this->container->get("event_dispatcher")->dispatch("security.interactive_login", $event);
    }
}