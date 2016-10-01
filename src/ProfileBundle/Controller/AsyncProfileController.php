<?php

namespace ProfileBundle\Controller;

use SubdivisionBundle\Entity\Job;
use SubdivisionBundle\Form\EducationType;
use SubdivisionBundle\Form\JobType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/profile")
 */
class AsyncProfileController extends Controller
{
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
        /*** @var Job $job */
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

    protected function getFormForUser($job)
    {
        $user = $this->getUser();
        $form = ($user->isStudent()) ? $this->createForm(new EducationType($job), $job) : $this->createForm(new JobType($job), $job);
        return $form;
    }

    protected function getTableView()
    {
        $user = $this->getUser();
        return ($user->isStudent()) ? "ProfileBundle:Profile:table_jobs_student.html.twig" : "ProfileBundle:Profile:table_jobs.html.twig";

    }

    protected function getFormView()
    {
        $user = $this->getUser();
        return ($user->isStudent()) ? "ProfileBundle:Profile:form_job_student.html.twig" : "ProfileBundle:Profile:form_job.html.twig";
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

        /*** @var Form $form */
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
}