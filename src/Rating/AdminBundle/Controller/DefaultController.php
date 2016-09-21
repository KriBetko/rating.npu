<?php

namespace Rating\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="admin_index")
     * @Template("RatingAdminBundle::index.html.twig")
     */
    public function indexAction()
    {
        return $this->redirect($this->generateUrl('user'));
    }
}
