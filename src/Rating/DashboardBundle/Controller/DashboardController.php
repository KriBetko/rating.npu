<?php

namespace Rating\DashboardBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * @Route("/dashboard")
 */
class DashboardController extends Controller
{
    /**
     * @Route("/")
     */
    public function indexAction()
    {
        return $this->render("RatingDashboardBundle:Dashboard:index.html.twig");
    }
}
