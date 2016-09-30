<?php

namespace Rating\ProfileBundle\Controller;

use Rating\SubdivisionBundle\Entity\Job;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AsyncProfileController extends Controller
{
    /**
     * @Route("/async/save/job", name="profile_save_job")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function asyncSaveJobAction(Request $request)
    {
        $profileController = new ProfileController();
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $status = 0;
        /*** @var Job $job */
        $job = new Job();
        $form = $profileController->getFormForUser($job);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $job->setUser($user);
            $em->persist($job);
            $em->flush();
            $jobs = $em->getRepository('RatingSubdivisionBundle:Job')->findUserJobs($user);
            $status = 1;
            $view = $this->render($profileController->getTableView(), array('jobs' => $jobs,))->getContent();
        } else {
            $view = $this->render($profileController->getFormView(), array(
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
        $profileController = new ProfileController();
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $status = 0;
        $job = $em->getRepository('RatingSubdivisionBundle:Job')->findOneBy(array('id' => $id, 'user' => $user));

        /*** @var Form $form */
        $form = $profileController->getFormForUser($job);

        if ($request->getMethod() == 'POST') {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $em->flush();
                $jobs = $em->getRepository('RatingSubdivisionBundle:Job')->findUserJobs($user);
                $status = 1;
                $view = $this->render($profileController->getTableView(), array('jobs' => $jobs,))->getContent();
                return $this->get('app.sender')->sendJson(array('status' => $status, 'view' => $view));
            }
        }

        $view = $this->render($profileController->getFormView(), array(
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
        $profileController = new ProfileController();
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $job = $em->getRepository('RatingSubdivisionBundle:Job')->findOneBy(array('id' => $id, 'user' => $user));
        $em->remove($job);
        $em->flush();
        $jobs = $em->getRepository('RatingSubdivisionBundle:Job')->findUserJobs($user);
        $view = $this->render($profileController->getTableView(), array('jobs' => $jobs,))->getContent();

        return $this->get('app.sender')->sendJson(array('status' => 1, 'view' => $view));
    }
}