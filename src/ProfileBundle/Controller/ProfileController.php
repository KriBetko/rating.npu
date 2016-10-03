<?php

namespace ProfileBundle\Controller;

use Doctrine\ORM\EntityManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use SubdivisionBundle\Entity\Job;
use SubdivisionBundle\Form\EducationType;
use SubdivisionBundle\Form\JobType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use UserBundle\Form\UserType;


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
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();

        $job = new Job();
        $job->setUser($user);
        $form = $this->getFormForUser($job);
        $jobs = $em->getRepository('SubdivisionBundle:Job')->findUserJobs($user);
        $ratings = $em->getRepository('AppBundle:UserRating')->findBy(array('user' => $user));

        return $this->render("ProfileBundle::index.html.twig", array(
            'user' => $user,
            'jobs' => $jobs,
            'formJob' => $form->createView(),
            'tableView' => $this->getTableView(),
            'formView' => $this->getFormView(),
            'ratings' => $ratings
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
        return ($user->isStudent()) ? "ProfileBundle::table_jobs_student.html.twig" : "ProfileBundle::table_jobs.html.twig";

    }

    protected function getFormView()
    {
        $user = $this->getUser();
        return ($user->isStudent()) ? "ProfileBundle::form_job_student.html.twig" : "ProfileBundle::form_job.html.twig";
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
        if ($form->isValid()) {
            $job->setUser($user);
            $em->persist($job);
            $em->flush();
            $jobs = $em->getRepository('SubdivisionBundle:Job')->findUserJobs($user);
            $status = 1;
            $view = $this->render($this->getTableView(), array('jobs' => $jobs,))->getContent();
        } else {
            $view = $this->render($this->getFormView(), array(
                'user' => $user,
                'formJob' => $form->createView()
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
        $job = $em->getRepository('SubdivisionBundle:Job')->findOneBy(array('id' => $id, 'user' => $user));
        $form = $this->getFormForUser($job);

        if ($request->getMethod() == 'POST') {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $em->flush();
                $jobs = $em->getRepository('SubdivisionBundle:Job')->findUserJobs($user);
                $status = 1;
                $view = $this->render($this->getTableView(), array('jobs' => $jobs,))->getContent();
                return $this->get('app.sender')->sendJson(array('status' => $status, 'view' => $view));
            }

        }
        $view = $this->render($this->getFormView(), array(
            'user' => $user,
            'formJob' => $form->createView(),
            'job' => $job,
            'update' => true,

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
        $job = $em->getRepository('SubdivisionBundle:Job')->findOneBy(array('id' => $id, 'user' => $user));
        $em->remove($job);
        $em->flush();
        $jobs = $em->getRepository('SubdivisionBundle:Job')->findUserJobs($user);
        $view = $this->render($this->getTableView(), array('jobs' => $jobs,))->getContent();

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

        if ($request->getMethod() == 'POST') {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $em->flush();
                $this->addFlash('success_update', '1');
                return $this->redirect($this->generateUrl('my_profile'));
            }
        }

        return $this->render('ProfileBundle::edit_profile.html.twig',
            array(
                'form' => $form->createView()
            ));
    }


}
