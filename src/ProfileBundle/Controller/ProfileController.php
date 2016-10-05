<?php

namespace ProfileBundle\Controller;

use AppBundle\Entity\Year;
use Doctrine\ORM\EntityManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use SubdivisionBundle\Entity\Job;
use SubdivisionBundle\Form\EducationType;
use SubdivisionBundle\Form\JobType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use UserBundle\Entity\User;
use UserBundle\Form\UserType;


/**
 * @Route("/profile")
 */
class ProfileController extends Controller
{
    /**
     * @Route("/", name="profile")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();
        /** @var User $user */
        $user = $this->getUser();
        /** @var Year $year */
        $year = $this->get('year.manager')->getCurrentYear();
        $jobs = $em->getRepository('SubdivisionBundle:Job')->findBy(array('user' => $user, 'year' => $year));
        $ratings = $em->getRepository('AppBundle:UserRating')->findBy(array('user' => $user));

        $job = new Job();
        $job->setUser($user);
        $form = $this->getFormForUser($job);

        $block = $user->getAvailableYear() == $year;

        return $this->render("ProfileBundle::index.html.twig", array(
            'user' => $user,
            'jobs' => $jobs,
            'tableView' => $this->getTableView(),
            'formView' => $this->getFormView(),
            'ratings' => $ratings,
            'years' => $this->get('year.manager')->getYears(),
            'formJob' => $form->createView(),
            'block' => $block
        ));
    }

    protected function getFormForUser($job)
    {
        $user = $this->getUser();
        $form = ($user->isStudent()) ? $this->createForm(new EducationType($job), $job) : $this->createForm(new JobType($job), $job);
        return $form;
    }

    protected function getTableView()
    {
        return $this->getUser()->isStudent() ? "ProfileBundle::table_jobs_student.html.twig" : "ProfileBundle::table_jobs.html.twig";

    }

    protected function getFormView()
    {
        return $this->getUser()->isStudent() ? "ProfileBundle::form_job_student.html.twig" : "ProfileBundle::form_job.html.twig";
    }

    /**
     * @Route("/edit", name="profile_edit")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function editProfileAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $form = $this->createForm(new UserType(), $user);

        if ($request->getMethod() == 'POST') {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $em->flush();
                $this->addFlash('success_update', '1');
                return $this->redirect($this->generateUrl('profile'));
            }
        }

        return $this->render('ProfileBundle::edit_profile.html.twig',
            array(
                'form' => $form->createView()
            ));
    }
}
