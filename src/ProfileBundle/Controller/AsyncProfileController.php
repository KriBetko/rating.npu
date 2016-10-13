<?php

namespace ProfileBundle\Controller;

use AppBundle\Entity\Year;
use Doctrine\DBAL\Types\BooleanType;
use Doctrine\ORM\EntityManager;
use SubdivisionBundle\Entity\Job;
use SubdivisionBundle\Form\EducationType;
use SubdivisionBundle\Form\JobType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use UserBundle\Entity\User;

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
        /** @var User $user */
        $user = $this->getUser();
        $status = 0;
        /*** @var Job $job */
        $job = new Job();
        /** @var BooleanType $block */
        $block = $this->getBlock($user);

        /** @var Form $form */
        $form = $this->getFormForUser($job);
        $form->handleRequest($request);
        if ($form->isValid()) {
            $job->setUser($user);
            $job->setYear($user->getAvailableYear());
            $em->persist($job);
            $em->flush();
            $this->get('service.rating')->calculateBetsForCathedra($job->getCathedra(), $job->getYear());
            $this->get('service.rating')->calculateBetsForCathedra($job->getCathedra(), $job->getYear());
            $jobs = $em->getRepository('SubdivisionBundle:Job')->findBy(array('year' => $user->getAvailableYear()));
            $status = 1;
            $view = $this->render($this->getTableView(), array('jobs' => $jobs, 'block' => $block))->getContent();
        } else {
            $view = $this->render($this->getFormView(), array(
                'user' => $user,
                'formJob' => $form->createView(),
                'block' => $block
            ))->getContent();
        }
        return $this->get('app.sender')->sendJson(array('status' => $status, 'view' => $view));
    }

    /**
     * @param User $user
     * @param $yearId
     * @return bool
     */
    private function getBlock($user, $yearId = null)
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();
        /** @var Year $year */
        $year = $yearId == null ? $this->get('year.manager')->getCurrentYear()
            : $em->getRepository('AppBundle:Year')->findOneBy(array('id' => $yearId));
        return $user->getAvailableYear() == $year;
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
     * @Route("/async/edit/job/{id}", name="profile_edit_job")
     * @param Request $request
     * @param null $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function asyncEditJobAction(Request $request, $id = null)
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();
        /** @var User $user */
        $user = $this->getUser();
        $status = 0;
        /** @var Job $job */
        $job = $em->getRepository('SubdivisionBundle:Job')->findOneBy(array('id' => $id, 'user' => $user));
        /*** @var Form $form */
        $form = $this->getFormForUser($job);
        /** @var BooleanType $block */
        $block = $this->getBlock($user);

        if ($request->getMethod() == 'POST') {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $em->flush();
                $this->get('service.rating')->calculateBetsForCathedra($job->getCathedra(), $job->getYear());
                $this->get('service.rating')->calculateBetsForCathedra($job->getCathedra(), $job->getYear());
                $jobs = $em->getRepository('SubdivisionBundle:Job')->findUserJobs($user);
                $status = 1;
                $view = $this->render($this->getTableView(), array('jobs' => $jobs, 'block' => $block))->getContent();
                return $this->get('app.sender')->sendJson(array('status' => $status, 'view' => $view));
            }
        }

        $view = $this->render($this->getFormView(), array(
            'user' => $user,
            'formJob' => $form->createView(),
            'job' => $job,
            'update' => true,
            'block' => $block
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
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();
        /** @var User $user */
        $user = $this->getUser();
        /** @var Job $job */
        $job = $em->getRepository('SubdivisionBundle:Job')->findOneBy(array('id' => $id, 'user' => $user));
        $em->remove($job);
        $em->flush();
        $this->get('service.rating')->calculateBetsForCathedra($job->getCathedra(), $job->getYear());
        $this->get('service.rating')->calculateBetsForCathedra($job->getCathedra(), $job->getYear());
        $jobs = $em->getRepository('SubdivisionBundle:Job')->findUserJobs($user);
        $block = $this->getBlock($user);
        $view = $this->render($this->getTableView(), array('jobs' => $jobs, 'block' => $block))->getContent();
        return $this->get('app.sender')->sendJson(array('status' => 1, 'view' => $view));
    }

    /**
     * @Route("/async/get/jobs/{id}", name="profile_get_jobs")
     * @param null $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function asyncGetJobsByYeear($id = null)
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();
        /** @var User $user */
        $user = $this->getUser();
        /** @var Year $year */
        $year = $id == null ? $this->get('year.manager')->getCurrentYear()
            : $em->getRepository('AppBundle:Year')->findOneBy(array('id' => $id));
        $jobs = $em->getRepository('SubdivisionBundle:Job')->findBy(array('user' => $user, 'year' => $year));
        /** @var BooleanType $block */
        $block = $this->getBlock($user, $id);
        $view = $this->render($this->getTableView(), array('jobs' => $jobs, 'block' => $block))->getContent();
        return $this->get('app.sender')->sendJson(array('status' => 1, 'view' => $view));
    }
}