<?php

namespace Rating\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class MainController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction()
    {
        return $this->render(
            'RatingMainBundle:Main:index.html.twig',
            [
                'authUrl'   =>  $this->get('google.oauth')->getAuthUrl()
            ]
        );
    }
}
