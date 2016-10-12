<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Category;
use AppBundle\Entity\CathedraRating;
use AppBundle\Entity\Criterion;
use AppBundle\Entity\InstituteRating;
use AppBundle\Entity\Measure;
use AppBundle\Entity\UserRating;
use AppBundle\Entity\Year;
use AppBundle\Form\MeasureType;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\DBAL\Types\IntegerType;
use Doctrine\ORM\EntityManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use SubdivisionBundle\Entity\Cathedra;
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

                    $this->calculateRating($measure->getJob()->getCathedra());

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

    /** @param Cathedra $cathedra */
    private function calculateRating($cathedra)
    {
        /*** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();
        /*** @var \UserBundle\Entity\User $user */
        $user = $this->getUser();
        /*** @var Year $year */
        $year = $em->getRepository('AppBundle:Year')->findOneBy(array('id' => $user->getAvailableYear()));

        /* Update user rating */
        /** @var IntegerType $totalUserRating */
        $totalUserRating = 0;

        /*** @var Job $job */
        foreach ($em->getRepository('SubdivisionBundle:Job')->findUserJobs($user) as $job) {
            $jobRating = 0;
            $measures = $em->getRepository('AppBundle:Measure')->findBy(array('job' => $job, 'year' => $year));

            /*** @var Measure $measure */
            foreach ($measures as $measure) {
                $result = $measure->getResult();
                $jobRating = $jobRating + $result;
                $totalUserRating = $totalUserRating + $result;
            }

            $job->setRating($jobRating);
        }

        $user->setRating($totalUserRating);

        /*** @var UserRating $userRating */
        $userRating = $em->getRepository('AppBundle:UserRating')->findOneBy(array('user' => $user, 'year' => $year));

        if ($userRating == null) {
            $userRating = new UserRating();
            $userRating->setUser($user);
            $userRating->setYear($year);
            $userRating->setValue($totalUserRating);

            $em->persist($userRating);
        } else {
            $userRating->setValue($totalUserRating);
        }

        /* Update cathedra rating */
        /*** @var CathedraRating $cathedraRating */
        $cathedraRating = $em->getRepository('AppBundle:CathedraRating')->findOneBy(array('cathedra' => $cathedra, 'year' => $year));

        $cathedraCriterionRating = $this->getCriterionRating(3);
        $cathedraBets = 0.0;
        $cathedraUserRating = 0;

        $jobs = $em->getRepository('SubdivisionBundle:Job')->findBy(array('cathedra' => $cathedra));
        /** @var Job $teacher */
        foreach ($jobs as $job) {
            $cathedraBets += $job->getBet();
            $cathedraUserRating += $job->getRating();
        }

        if ($cathedraRating == null) {
            $cathedraRating = new CathedraRating();
            $cathedraRating->setCathedra($cathedra);
            $cathedraRating->setYear($year);
            $cathedraRating->setValue($cathedraCriterionRating + ($cathedraUserRating / $cathedraBets));
            $em->persist($cathedraRating);
        } else {
            $cathedraRating->setValue($cathedraCriterionRating + ($cathedraUserRating / $cathedraBets));
        }

        $cathedra->setRating($cathedraRating);

        /* Update institute rating */
        $institute = $cathedra->getInstitute();

        $instituteCriterionRating = $this->getCriterionRating(4);
        $cathedrasRating = 0;

        /** @var array $cathedras */
        $cathedras = $em->getRepository('SubdivisionBundle:Cathedra')->findBy(array('institute' => $institute));

        /** @var Cathedra $cathedra */
        foreach ($cathedras as $cathedra) {
            $cathedrasRating += $cathedra->getRating();
        }

        $instituteRating = $em->getRepository('AppBundle:InstituteRating')->findOneBy(array('institute' => $institute, 'year' => $year));

        if ($instituteRating == null) {
            $instituteRating = new InstituteRating();
            $instituteRating->setInstitute($institute);
            $instituteRating->setYear($year);
            $instituteRating->setValue($instituteCriterionRating + ($cathedrasRating / count($cathedras)));
            $em->persist($instituteRating);
        } else {
            $instituteRating->setValue($instituteCriterionRating + ($cathedrasRating / count($cathedras)));
        }

        $institute->setRating($instituteRating);

        $em->flush();
    }

    /**
     * @param integer $id
     * @return integer
     */
    private function getCriterionRating($id)
    {
        /*** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        $totalRating = 0;

        $categories = $em->getRepository('AppBundle:Category')->findBy(array('type' => $id));
        /** @var Category $category */
        foreach ($categories as $category) {
            $criterias = $category->getCriteria();
            /** @var Criterion $criteria */
            foreach ($criterias as $criteria) {
                $measures = $em->getRepository('AppBundle:Measure')->findBy(array('criterion' => $criteria));
                /** @var Measure $measure */
                foreach ($measures as $measure) {
                    $totalRating += $measure->getValue();
                }
            }
        }

        return $totalRating;
    }
}
