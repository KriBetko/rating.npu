<?php
namespace Rating\SubdivisionBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/profile")
 */
class MainController extends Controller
{
    /**
     * @Route("/management/", name="cathedras_list")
     */
    public function listAction (Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();

        $cathedras = $user->getCathedras()->toArray();
        $cathedrasIDs = [];
        foreach ($cathedras as $c) {
            $cathedrasIDs[] = $c->getId();
        }
        $institutes = $user->getInstitutes()->toArray();

        $institutesIDs = [];
        foreach ($institutes as $i) {
            $institutesIDs[] = $i->getId();
        }

        $institutes = $em->getRepository("RatingSubdivisionBundle:Institute")->findAll();

        return $this->render('RatingSubdivisionBundle::cathedras.html.twig',
            [
                'cathedrasIDs'    => $cathedrasIDs,
                'institutesIDs' => $institutesIDs,
                'institutes'   => $institutes
            ]
        );
    }
    /**
     * @Route("/cathedra/{id}", name="profile_cathedra_show")
     */
    public function showCathedraAction (Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $cathedra = $em->getRepository("RatingSubdivisionBundle:Cathedra")->findOneById($id);
        $users = $em->getRepository('AppBundle:Measure')->getValue($cathedra);
        $total = 0;
        foreach ($users as $u) {
            $total += $u['summa'];
        }
        return $this->render('RatingSubdivisionBundle::cathedra.html.twig',
            [
                'cathedra'    => $cathedra,
                'users'         => $users,
                'total'         => $total
            ]
        );
    }

    /**
     * @Route("/user/{id}/show", name="profile_user_show")
     */
    public function showUserAction (Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository("RatingUserBundle:User")->findOneById($id);
        $year = $this->get('year.manager')->getCurrentYear();
        $this->get('year.manager')->generateMeasureForAllUser($year, $user);

        $measures = $em->getRepository('AppBundle:Measure')->getUserMeasures($year, $user);

        return $this->render('RatingSubdivisionBundle::user.html.twig',
            [
                'user' => $user,
                'measures'  => $measures
            ]
        );
    }

    /**
     * @Route("/institute/{id}", name="profile_institute_show")
     */
    public function showInstituteAction (Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $institute = $em->getRepository("RatingSubdivisionBundle:Institute")->findOneById($id);

        return $this->render('RatingSubdivisionBundle::cathedras.html.twig',
            [
                'institute'    => $institute
            ]
        );
    }
}