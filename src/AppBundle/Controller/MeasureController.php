<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Field;
use AppBundle\Form\MeasureType;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Response;

class MeasureController extends Controller
{

    /**
     * @Route("/profile/measure", name="my_measure")
     * @Method("GET")
     */
    public function myAction()
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $year = $this->get('year.manager')->getCurrentYear();
        $this->get('year.manager')->generateMeasureForAllUser($year, $user);

        $measures = $em->getRepository('AppBundle:Measure')->getUserMeasures($year, $user);

        return $this->render('AppBundle:Measure:index.html.twig', array(
            'measures' => $measures,
        ));

    }

    /**
     * @Route("/profile/measure/edit/{id}", name="edit_measure")
     */
    public function editAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();

        $measure = $em->getRepository('AppBundle:Measure')->findOneBy(array('id' => $id));

        $form = $this->createForm(new MeasureType(), $measure);

        $originalFields = new ArrayCollection();

        foreach ($measure->getFields() as $field) {
            $originalFields->add($field);
        }

        if ($request->getMethod() == 'POST'){
            $form->handleRequest($request);
            if ($form->isValid()){

                foreach ($originalFields as $field) {
                    if (false === $measure->getFields()->contains($field)) {
                        $field->setMeasure(null);
                        $em->remove($field);
                    }
                }
                foreach ($measure->getFields() as $field) {

                    if (!$field->getTitle()){
                        $field->setMeasure(null);
                        $measure->removeField($field);
                        $em->remove($field);
                    }
                }
                $measure->setValue(count($measure->getFields()));
                $measure->setResult($measure->getCriterion()->getCoefficient() * $measure->getValue());
                $em->flush();
                return $this->get('app.sender')->sendJson(
                    array(
                        'status' => 1,
                        'measure' => $measure->getId(),
                        'total'     => $measure->getValue() * $measure->getCriterion()->getCoefficient(),
                        'category'  => $measure->getCriterion()->getCategory()->getId(),
                        'value'     => $measure->getValue(),
                        'job'       => $measure->getJob()->getId()
                    )
                );
            }

        }

        $view = $this->render("AppBundle:Measure:form.html.twig", array(
            'form'      => $form->createView(),
            'measure'   => $measure

        ))->getContent();

        return $this->get('app.sender')->sendJson(array('status' => 1, 'view' => $view));

    }

}
