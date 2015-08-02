<?php

namespace Rating\SubdivisionBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Rating\SubdivisionBundle\Entity\Cathedra;
use Rating\SubdivisionBundle\Form\CathedraType;
use Symfony\Component\HttpFoundation\Response;


class AsyncController extends Controller
{

    /**
     * @Route("/cathedras/get/{id}", name="get_cathedras")
     */
    public function getCathedrasAction (Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $institute = $em->getRepository('RatingSubdivisionBundle:Institute')->findOneById($id);
        if ($institute){
            $cathedras = $institute->getCathedras()->toArray();
        }
        $output = '';
        $status = 0;
        if ($cathedras) {
            foreach($cathedras as $cathedra){
                $output .= $this->render('RatingSubdivisionBundle:Cathedra:cathedra_list.html.twig', array('cathedra'=>$cathedra))->getContent();
            }
            $status = 1;
        }

        return $this->sendJson(array('status'=>$status, 'output' => $output));

    }
    protected function sendJson($data) {
        $response = new Response(json_encode($data));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }
}
