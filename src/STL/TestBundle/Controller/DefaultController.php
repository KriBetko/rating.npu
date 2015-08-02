<?php

namespace STL\TestBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Response;


/**
 * @Route("/test")
 */
class DefaultController extends Controller
{
    /**
     * @Route("")
     */
    public function indexAction()
    {
        return $this->render('STLTestBundle:Default:index.html.twig');
    }
}
