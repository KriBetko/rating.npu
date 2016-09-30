<?php

namespace Rating\ProfileBundle\Controller;

use Rating\SubdivisionBundle\Entity\Job;
use Rating\SubdivisionBundle\Form\EducationType;
use Rating\SubdivisionBundle\Form\JobType;
use Rating\UserBundle\Form\UserType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

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

        $job = new Job();
        $job->setUser($user);
        $form = $this->getFormForUser($job);
        $jobs = $em->getRepository('RatingSubdivisionBundle:Job')->findUserJobs($user);

        return $this->render("RatingProfileBundle:Profile:index.html.twig", array(
            'user'      => $user,
            'jobs'      => $jobs,
            'formJob'   => $form->createView(),
            'tableView' => $this->getTableView(),
            'formView'  => $this->getFormView()
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
        $user = $this->getUser();
        return ($user->isStudent()) ? "RatingProfileBundle:Profile:table_jobs_student.html.twig" : "RatingProfileBundle:Profile:table_jobs.html.twig";

    }

    protected function getFormView()
    {
        $user = $this->getUser();
        return ($user->isStudent()) ? "RatingProfileBundle:Profile:form_job_student.html.twig" : "RatingProfileBundle:Profile:form_job.html.twig";
    }

    /**
     * @Route("/edit", name="my_profile_edit")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function editProfileAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $form = $this->createForm(new UserType(), $user);

        if ($request->getMethod() == 'POST'){
            $form->handleRequest($request);
            if ($form->isValid()){
                $em->flush();
                $this->addFlash('success_update', '1');
                return $this->redirect($this->generateUrl('my_profile'));
            }
        }

        return $this->render('RatingProfileBundle:Profile:edit_profile.html.twig',
            array(
                'form' => $form->createView()
            ));
    }
}
