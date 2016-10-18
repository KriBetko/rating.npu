<?php
namespace SubdivisionBundle\Controller;

use SubdivisionBundle\Entity\Institute;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AsyncController extends Controller
{
    /**
     * @Route("/cathedras/get/{id}", name="get_cathedras")
     * @param Integer $id
     * @return Response
     */
    public function getCathedrasAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        /**
         * @var Institute $institute
         */
        $institute = $em->getRepository('SubdivisionBundle:Institute')->findBy(array('id' => $id));

        $output = '';
        $status = 0;

        if ($institute) {
            $cathedras = $institute->getCathedras()->toArray();

            if ($cathedras) {
                foreach ($cathedras as $cathedra) {
                    $output .= $this->render('SubdivisionBundle::cathedra_list.html.twig',
                        array('cathedra' => $cathedra))->getContent();
                }
                $status = 1;
            }
        }

        return $this->get('app.sender')->sendJson(array('status' => $status, 'output' => $output));
    }
}