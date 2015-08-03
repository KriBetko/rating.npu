<?php

namespace Rating\ProfileBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * @Route("/profile")
 */
class ProfileController extends Controller
{
    /**
     * @Route("/", name="my_profile")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $jobs = $em->getRepository('RatingSubdivisionBundle:Job')->findUserJobs($user);
        return $this->render("RatingProfileBundle:Profile:index.html.twig", array('user' => $user, 'jobs' => $jobs));
    }
}
