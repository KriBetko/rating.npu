<?php

namespace Rating\ProfileBundle\Controller;

use FOS\UserBundle\Event\FilterUserResponseEvent;
use FOS\UserBundle\Event\GetResponseUserEvent;
use Rating\UserBundle\Form\Type\ChangePasswordFormType;
use FOS\UserBundle\FOSUserEvents;
use FOS\UserBundle\Model\UserInterface;
use Rating\SubdivisionBundle\Form\JobType;
use Rating\SubdivisionBundle\Entity\Job;
use Rating\UserBundle\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

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
        $form = $this->createForm(new JobType(), $job);
        $jobs = $em->getRepository('RatingSubdivisionBundle:Job')->findUserJobs($user);

        return $this->render("RatingProfileBundle:Profile:index.html.twig", array(
            'user'      => $user,
            'jobs'      => $jobs,
            'formJob'   => $form->createView()
        ));
    }

    /**
     * @Route("/async/save/job", name="profile_save_job")
     */
    public function asyncSaveJobAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $status = 0;
        $job = new Job();
        $form = $this->createForm(new JobType(), $job);
        $form->handleRequest($request);
        if ($form->isValid()){
            $job->setUser($user);
            $em->persist($job);
            $em->flush();
            $jobs = $em->getRepository('RatingSubdivisionBundle:Job')->findUserJobs($user);
            $status = 1;
            $view =  $this->render("RatingProfileBundle:Profile:table_jobs.html.twig", array('jobs' => $jobs,))->getContent();
        } else {
            $view = $this->render("RatingProfileBundle:Profile:form_job.html.twig", array(
                'user'      => $user,
                'formJob'   => $form->createView()
            ))->getContent();
        }
        return $this->get('app.sender')->sendJson(array('status' => $status, 'view' => $view));
    }

    /**
     * @Route("/async/edit/job/{id}", name="profile_edit_job")
     */
    public function asyncEditJobAction(Request $request, $id = null)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $status = 0;
        $job = $em->getRepository('RatingSubdivisionBundle:Job')->findOneBy(array('id' => $id, 'user' => $user));
        $form = $this->createForm(new JobType(), $job);
        if ($request->getMethod() == 'POST'){
            $form->handleRequest($request);
            if ($form->isValid()){
                $em->flush();
                $jobs = $em->getRepository('RatingSubdivisionBundle:Job')->findUserJobs($user);
                $status = 1;
                $view =  $this->render("RatingProfileBundle:Profile:table_jobs.html.twig", array('jobs' => $jobs,))->getContent();
                return $this->get('app.sender')->sendJson(array('status' => $status, 'view' => $view));
            }

        }
        $view = $this->render("RatingProfileBundle:Profile:form_job.html.twig", array(
            'user'      => $user,
            'formJob'   => $form->createView(),
            'job'       => $job,
            'update'    => true,

        ))->getContent();
        return $this->get('app.sender')->sendJson(array('status' => $status, 'view' => $view));
    }

    /**
     * @Route("/async/remove/job/{id}", name="profile_remove_job")
     */
    public function asyncRemoveJobAction(Request $request, $id = null)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $job = $em->getRepository('RatingSubdivisionBundle:Job')->findOneBy(array('id' => $id, 'user' => $user));
        $em->remove($job);
        $em->flush();
        $jobs = $em->getRepository('RatingSubdivisionBundle:Job')->findUserJobs($user);
        $view =  $this->render("RatingProfileBundle:Profile:table_jobs.html.twig", array('jobs' => $jobs,))->getContent();

        return $this->get('app.sender')->sendJson(array('status' => 1, 'view' => $view));
    }


    /**
     * @Route("/edit", name="my_profile_edit")
     */
    public function editProfileAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $form = $this->createForm(new UserType(), $user);

        /** @var $dispatcher \Symfony\Component\EventDispatcher\EventDispatcherInterface */
        $dispatcher = $this->get('event_dispatcher');

        $event = new GetResponseUserEvent($user, $request);
        $dispatcher->dispatch(FOSUserEvents::CHANGE_PASSWORD_INITIALIZE, $event);

        if (null !== $event->getResponse()) {
            return $event->getResponse();
        }
        $formPass = $this->createForm(new ChangePasswordFormType(), $user);
        $formPass->setData($user);

        if ($request->getMethod() == 'POST'){
            $form->handleRequest($request);
            if ($form->isValid()){
                $userManager = $this->get('fos_user.user_manager');
                $userManager->updateUser($user, true);
                $this->addFlash('success_update', '1');
                return $this->redirect($this->generateUrl('my_profile'));

            }
            $formPass->handleRequest($request);
            if ($formPass->isValid()) {
                /** @var $userManager \FOS\UserBundle\Model\UserManagerInterface */
                $userManager = $this->get('fos_user.user_manager');
                $event = new FormEvent($formPass, $request);
                $dispatcher->dispatch(FOSUserEvents::CHANGE_PASSWORD_SUCCESS, $event);
                $userManager->updateUser($user);
                $url = $this->generateUrl('my_profile');
                $response = new RedirectResponse($url);
                $dispatcher->dispatch(FOSUserEvents::CHANGE_PASSWORD_COMPLETED, new FilterUserResponseEvent($user, $request, $response));
                $this->addFlash('success_update', '1');
                return $response;
            }
        }

        return $this->render('RatingProfileBundle:Profile:edit_profile.html.twig',
            array(
                'form' => $form->createView(),
                'formPass' => $formPass->createView()
            ));
    }

}
