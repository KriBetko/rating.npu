<?php

namespace Rating\ProfileBundle\Controller;

use Rating\SubdivisionBundle\Form\EducationType;
use Rating\SubdivisionBundle\Form\JobType;
use Rating\SubdivisionBundle\Entity\Job;
use Rating\UserBundle\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;


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

    /**
     * @Route("/async/save/job", name="profile_save_job")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function asyncSaveJobAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $status = 0;
        $job = new Job();
        $form = $this->getFormForUser($job);
        $form->handleRequest($request);
        if ($form->isValid()){
            $job->setUser($user);
            $em->persist($job);
            $em->flush();
            $jobs = $em->getRepository('RatingSubdivisionBundle:Job')->findUserJobs($user);
            $status = 1;
            $view =  $this->render($this->getTableView(), array('jobs' => $jobs,))->getContent();
        } else {
            $view = $this->render($this->getFormView(), array(
                'user'      => $user,
                'formJob'   => $form->createView()
            ))->getContent();
        }
        return $this->get('app.sender')->sendJson(array('status' => $status, 'view' => $view));
    }

    /**
     * @Route("/async/edit/job/{id}", name="profile_edit_job")
     * @param Request $request
     * @param null $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function asyncEditJobAction(Request $request, $id = null)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $status = 0;
        $job = $em->getRepository('RatingSubdivisionBundle:Job')->findOneBy(array('id' => $id, 'user' => $user));
        $form = $this->getFormForUser($job);

        if ($request->getMethod() == 'POST'){
            $form->handleRequest($request);
            if ($form->isValid()){
                $em->flush();
                $jobs = $em->getRepository('RatingSubdivisionBundle:Job')->findUserJobs($user);
                $status = 1;
                $view =  $this->render($this->getTableView(), array('jobs' => $jobs,))->getContent();
                return $this->get('app.sender')->sendJson(array('status' => $status, 'view' => $view));
            }

        }
        $view = $this->render($this->getFormView(), array(
            'user'      => $user,
            'formJob'   => $form->createView(),
            'job'       => $job,
            'update'    => true,

        ))->getContent();
        return $this->get('app.sender')->sendJson(array('status' => $status, 'view' => $view));
    }

    /**
     * @Route("/async/remove/job/{id}", name="profile_remove_job")
     * @param null $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function asyncRemoveJobAction($id = null)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $job = $em->getRepository('RatingSubdivisionBundle:Job')->findOneBy(array('id' => $id, 'user' => $user));
        $em->remove($job);
        $em->flush();
        $jobs = $em->getRepository('RatingSubdivisionBundle:Job')->findUserJobs($user);
        $view =  $this->render($this->getTableView(), array('jobs' => $jobs,))->getContent();

        return $this->get('app.sender')->sendJson(array('status' => 1, 'view' => $view));
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

    protected function getFormForUser($job)
    {
        $user = $this->getUser();
        $form = ($user->isStudent()) ? $this->createForm(new EducationType($job), $job) :  $this->createForm(new JobType($job), $job);
        return $form;
    }
    protected function getTableView()
    {
        $user = $this->getUser();
        return  ($user->isStudent()) ?  "RatingProfileBundle:Profile:table_jobs_student.html.twig" :  "RatingProfileBundle:Profile:table_jobs.html.twig";

    }
    protected function getFormView()
    {
        $user = $this->getUser();
        return  ($user->isStudent()) ?  "RatingProfileBundle:Profile:form_job_student.html.twig" :  "RatingProfileBundle:Profile:form_job.html.twig";
    }


}
