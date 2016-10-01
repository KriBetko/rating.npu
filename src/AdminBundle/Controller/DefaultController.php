<?php

namespace AdminBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="admin_index")
     * @Template("AdminBundle::index.html.twig")
     */
    public function indexAction()
    {
        return $this->redirect($this->generateUrl('user'));
    }
}
