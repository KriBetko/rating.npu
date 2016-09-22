<?php
namespace Rating\UserBundle\Auth;

use Rating\UserBundle\Entity\User;

class OAuthProvider
{
    protected $session, $doctrine, $admins;

    /**
     * OAuthProvider constructor.
     * @param $session
     * @param $doctrine
     * @param $service_container
     */
    public function __construct($session, $doctrine, $service_container)
    {
        $this->session = $session;
        $this->doctrine = $doctrine;
        $this->container = $service_container;
    }

    public function loadUserByUsername($username)
    {

        $qb = $this->doctrine->getManager()->createQueryBuilder();
        $qb->select('u')
            ->from('RatingUserBundle:User', 'u')
            ->where('u.googleId = :gid')
            ->setParameter('gid', $username)
            ->setMaxResults(1);
        $result = $qb->getQuery()->getResult();

        if (count($result)) {
            return $result[0];
        } else {
            return new User();
        }
    }

    public function loadUserByOAuthUserResponse(UserResponseInterface $response)
    {
        //Data from Google response
        $responseArray = $response->getResponse();
        if (!isset($responseArray['hd']) || ($responseArray['hd'] != 'npu.edu.ua' && $responseArray['hd'] != 'std.npu.edu.ua') )
        {
            $token = new User();
            return $token;
            //return new RedirectResponse($this->container->get('router')->generate('homepage'));
        }
        $google_id = $response->getUsername(); /* An ID like: 112259658235204980084 */
        $email = $response->getEmail();
        $firstname = $response->getNickname();
        $surname = $response->getRealName();
        //$avatar = $response->getProfilePicture();


        $qb = $this->doctrine->getManager()->createQueryBuilder();
        $qb->select('u')
            ->from('RatingUserBundle:User', 'u')
            ->where('u.googleId = :gid')
            ->setParameter('gid', $google_id)
            ->setMaxResults(1);
        $result = $qb->getQuery()->getResult();

        //add to database if doesn't exists
        if (!count($result)) {
            $user = new User();
            $user->setFirstName($firstname);
            $user->setLastName($surname);
            $user->setGoogleId($google_id);
            $user->setEmail($email);
            $user->setParentName($firstname);

            if ($responseArray['hd'] == 'npu.edu.ua')
            {
                $user->addRole('ROLE_USER');
                $user->addRole('ROLE_TEACHER');

            }
            if ($responseArray['hd'] == 'std.npu.edu.ua'){
                $user->addRole('ROLE_USER');
                $user->addRole('ROLE_TEACHER');
            }


            //Set some wild random pass since its irrelevant, this is Google login
            $factory = $this->container->get('security.encoder_factory');
            $encoder = $factory->getEncoder($user);
            $password = $encoder->encodePassword(md5(uniqid()), $user->getSalt());
            $user->setPassword($password);

            $em = $this->doctrine->getManager();
            $em->persist($user);
            $em->flush();
        } else {
            $user = $result[0]; /* return User */
        }

        //set id
        $this->session->set('id', $user->getId());

        return $this->loadUserByUsername($response->getUsername());
    }

    public function supportsClass($class)
    {
        return $class === 'Rating\\UserBundle\\Entity\\User';
    }
}