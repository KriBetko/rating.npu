<?php
namespace Rating\SubdivisionBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

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
        return $this->get('app.sender')->sendJson(array('status'=>$status, 'output' => $output));
    }
}