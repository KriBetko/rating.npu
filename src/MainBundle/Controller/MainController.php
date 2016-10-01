<?php

namespace MainBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class MainController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction()
    {
        return $this->render(
            'MainBundle::index.html.twig',
            [
                'authUrl' => $this->get('google.oauth')->getAuthUrl()
            ]
        );
    }
}
