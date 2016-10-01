<?php

namespace System\AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    /**
     * @Route("/hello/{name}")
     * @param $name
     * @return array
     */
    public function indexAction($name)
    {
        return array('name' => $name);
    }
}
