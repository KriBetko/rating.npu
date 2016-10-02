<?php

namespace AppBundle\Controller;


use AppBundle\Entity\Measure;
use AppBundle\Entity\Rating;
use AppBundle\Entity\Year;
use AppBundle\Form\MeasureType;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\DBAL\Types\IntegerType;
use Doctrine\ORM\EntityManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use SubdivisionBundle\Entity\Job;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


class MeasureController extends Controller
{

    /**
     * @Route("/profile/measure/{yearId}", name="my_measure")
     * @Method("GET")
     * @param null $yearId
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function myAction($yearId = null)
    {
        $em = $this->getDoctrine()->getManager();
        $yearEntity = $em->getRepository('AppBundle:Year')->findOneBy(['id' => $yearId]);
        $user = $this->getUser();
        $year = $yearEntity instanceof Year ? $yearEntity : $this->get('year.manager')->getCurrentYear();
        $this->get('year.manager')->generateMeasureForAllUser($year, $user);

        $measures = $em->getRepository('AppBundle:Measure')->getUserMeasures($year, $user);

        return $this->render('AppBundle:Measure:index.html.twig', array(
            'measures' => $measures,
            'years' => $this->get('year.manager')->getYears(),
            'year' => $year,
            'block' => $user->isBlock()
        ));
    }

    /**
     * @Route("/profile/measure/edit/{id}", name="edit_measure")
     * @param Request $request
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function editAction(Request $request, $id)
    {
        if (!$this->getUser()->isBlock()) {
            $em = $this->getDoctrine()->getManager();

            /*** @var Measure $measure */
            $measure = $em->getRepository('AppBundle:Measure')->findOneBy(array('id' => $id));

            $form = $this->createForm(new MeasureType($measure), $measure);

            $originalFields = new ArrayCollection();

            foreach ($measure->getFields() as $field) {
                $originalFields->add($field);
            }

            if ($request->getMethod() == 'POST') {
                $form->handleRequest($request);
                if ($form->isValid()) {
                    foreach ($originalFields as $field) {
                        if (false === $measure->getFields()->contains($field)) {
                            $field->setMeasure(null);
                            $em->remove($field);
                        }
                    }

                    foreach ($measure->getFields() as $field) {

                        if (!$field->getTitle()) {
                            $field->setMeasure(null);
                            $measure->removeField($field);
                            $em->remove($field);
                        }
                    }

                    if ($measure->getCriterion()->isPlural()) {
                        $measure->setValue(count($measure->getFields()));
                        $measure->setResult($measure->getCriterion()->getCoefficient() * $measure->getValue());
                    } else {
                        $measure->setResult($measure->getCriterion()->getCoefficient() * $measure->getValue());
                    }

                    $em->flush();

                    $this->calculateUserRating();

                    return $this->get('app.sender')->sendJson(
                        array(
                            'status' => 1,
                            'measure' => $measure->getId(),
                            'total' => $measure->getValue() * $measure->getCriterion()->getCoefficient(),
                            'category' => $measure->getCriterion()->getCategory()->getId(),
                            'value' => $measure->getValue(),
                            'job' => $measure->getJob()->getId()
                        )
                    );
                }
            }

            $singleGroup = false;
            if ($measure->getCriterion()->getGroup() && !$measure->getCriterion()->getGroup()->isPlural()) {
                $groupedMeasure = $em->getRepository('AppBundle:Measure')->getGroupedMeasure($measure);
                $singleGroup = $groupedMeasure ? true : false;
            }

            $view = $this->render("AppBundle:Measure:form.html.twig", array(
                'form' => $form->createView(),
                'measure' => $measure,
                'singleGroup' => $singleGroup

            ))->getContent();

            return $this->get('app.sender')->sendJson(array('status' => 1, 'view' => $view));
        } else {
            return $this->get('app.sender')->sendJson(array('status' => 0));
        }
    }

    private function calculateUserRating()
    {
        /*** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        /*** @var \UserBundle\Entity\User $user */
        $user = $this->getUser();

        /*** @var IntegerType $rating */
        $rating = 0;

        $jobs = $em->getRepository('SubdivisionBundle:Job')->findUserJobs($user);
        /*** @var Job $job */
        foreach ($jobs as $job) {
            $jobRating = 0;
            $measures = $em->getRepository('AppBundle:Measure')->findBy(array('job' => $job->getId()));

            /*** @var Measure $measure */
            foreach ($measures as $measure) {
                $result = $measure->getResult();
                $jobRating = $jobRating + $result;
                $rating = $rating + $result;
            }

            $job->setRating($jobRating);
        }

        $user->setRating($rating);

        /*** @var Year $year */
        $year = $em->getRepository('AppBundle:Year')->findOneBy(array('id' => $user->getAvailableYear()));
        /*** @var Rating $ratingObj */
        $ratingObj = $em->getRepository('AppBundle:Rating')->findOneBy(array('user' => $user, 'year' => $year));

        if ($ratingObj == null) {
            $ratingObj = new Rating();
            $ratingObj->setUser($user);
            $ratingObj->setYear($year);
            $ratingObj->setRating($rating);

            $em->persist($ratingObj);
        } else {
            $ratingObj->setUser($user);
            $ratingObj->setYear($year);
            $ratingObj->setRating($rating);
        }

        $em->flush();
    }

    private function calculateCathedraRating($cathedra)
    {
        //TODO
    }

    private function caculateFacultieRating($facultie)
    {
        //TODO
    }
}
