<?php
namespace SubdivisionBundle\Controller;

use Doctrine\ORM\EntityManager;
use SubdivisionBundle\Entity\Cathedra;
use SubdivisionBundle\Entity\Institute;
use SubdivisionBundle\Entity\Job;
use SubdivisionBundle\Form\FilterStudentType;
use SubdivisionBundle\Form\FilterType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use UserBundle\Entity\User;

/**
 * @Route("/")
 */
class MainController extends Controller
{
    /**
     * @Route("/management/", name="cathedras_list")
     * @return \Symfony\Component\HttpFoundation\Response
     * @internal param Request $request
     */
    public function listAction()
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        $institutes = $em->getRepository("SubdivisionBundle:Institute")->findAllByRating();

        return $this->render('SubdivisionBundle::management.html.twig',
            [
                'institutes' => $institutes
            ]
        );
    }

    /**
     * @Route("/rating/teachers", name="rating_teachers")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function ratingAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $year = $request->query->get('job')['years'] ?: $this->get('year.manager')->getCurrentYear()->getId();

        $filterJob = new Job();
        $form = $this->createForm(new FilterType(), $filterJob, array(
            'action' => $this->generateUrl('rating_teachers'),
            'method' => 'GET',
        ));
        $form->add('submit', 'submit', array('label' => 'Фільтрувати', 'attr' => array(
            'class' => 'btn btn-success')));
        $form->handleRequest($request);
        $users = $em->getRepository('AppBundle:Measure')->getRatings($year, $filterJob);
        return $this->render('SubdivisionBundle::rating.html.twig',
            [
                'users' => $users,
                'form' => $form->createView()
            ]
        );
    }

    /**
     * @Route("/rating/students", name="rating_students")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function ratingStudentAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $year = $request->query->get('job')['years'] ?: $this->get('year.manager')->getCurrentYear()->getId();

        $filterJob = new Job();
        $form = $this->createForm(new FilterStudentType($em), $filterJob, array(
            'action' => $this->generateUrl('rating_students'),
            'method' => 'GET',
        ));
        $form->add('submit', 'submit', array('label' => 'Фільтрувати', 'attr' => array(
            'class' => 'btn btn-success')));
        $form->handleRequest($request);
        $users = $em->getRepository('AppBundle:Measure')->getStudentRatings($year, $filterJob);
        return $this->render('SubdivisionBundle::rating_student.html.twig',
            [
                'users' => $users,
                'form' => $form->createView()
            ]
        );
    }

    /**
     * @Route("/cathedra/{id}", name="profile_cathedra_show")
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     * @internal param Request $request
     */
    public function showCathedraAction($id)
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();
        /** @var Cathedra $cathedra */
        $cathedra = $em->getRepository("SubdivisionBundle:Cathedra")->findOneBy(array('id' => $id));
        $users = $em->getRepository('AppBundle:Measure')->getValue($cathedra);
        $jobs = $em->getRepository('SubdivisionBundle:Job')->findBy(array('cathedra' => $cathedra));

        $bets = 0.0;
        /** @var Job $job */
        foreach ($jobs as $job) {
            $bets += $job->getBet();
        }

        return $this->render('SubdivisionBundle::cathedra.html.twig',
            [
                'cathedra' => $cathedra,
                'users' => $users,
                'total' => $cathedra->getRating(),
                'bets' => $bets
            ]
        );
    }

    /**
     * @Route("/user/{id}/show", name="profile_user_show")
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     * @internal param Request $request
     */
    public function showUserAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository("UserBundle:User")->findOneBy(array('id' => $id));
        $year = $this->get('year.manager')->getCurrentYear();
        $this->get('year.manager')->generateMeasureForAllUser($year, $user);

        $measures = $em->getRepository('AppBundle:Measure')->getUserMeasures($year, $user);

        return $this->render('SubdivisionBundle::user.html.twig',
            [
                'user' => $user,
                'measures' => $measures
            ]
        );
    }

    /**
     * @Route("/institute/{id}", name="profile_institute_show")
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     * @internal param Request $request
     */
    public function showInstituteAction($id)
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();
        $institute = $em->getRepository("SubdivisionBundle:Institute")->findOneBy(array('id' => $id));

        return $this->render('SubdivisionBundle::management.html.twig',
            [
                'institute' => $institute
            ]
        );
    }
}