<?php

namespace ServiceBundle\Service;

use AppBundle\Entity\Category;
use AppBundle\Entity\CathedraRating;
use AppBundle\Entity\Criterion;
use AppBundle\Entity\InstituteRating;
use AppBundle\Entity\Measure;
use AppBundle\Entity\UserRating;
use AppBundle\Entity\Year;
use Doctrine\DBAL\Types\DecimalType;
use Doctrine\DBAL\Types\IntegerType;
use Doctrine\ORM\EntityManager;
use SubdivisionBundle\Entity\Cathedra;
use SubdivisionBundle\Entity\Institute;
use SubdivisionBundle\Entity\Job;
use UserBundle\Entity\User;

class Rating
{
    private $entityManager;

    /*** @param EntityManager $entityManager */
    public function __construct($entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param User $user
     * @param Cathedra $cathedra
     */
    public function calculateRating($user, $cathedra)
    {
        /*** @var Year $year */
        $year = $this->entityManager->getRepository('AppBundle:Year')->findOneBy(array('id' => $user->getAvailableYear()));

        $this->calculateRatingForUser($user, $year);
        $this->calculateRatingForCathedras($cathedra, $year);
        $this->calculateRatingForInstitute($cathedra->getInstitute(), $year);
    }

    /**
     * @param User $user
     * @param Year $year
     */
    private function calculateRatingForUser($user, $year)
    {
        /** @var IntegerType $totalUserRating */
        $totalUserRating = 0;

        /*** @var Job $job */
        foreach ($this->entityManager->getRepository('SubdivisionBundle:Job')->findUserJobs($user) as $job) {
            $jobRating = 0;
            $measures = $this->entityManager->getRepository('AppBundle:Measure')->findBy(array('job' => $job, 'year' => $year));

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
        $userRating = $this->entityManager->getRepository('AppBundle:UserRating')->findOneBy(array('user' => $user, 'year' => $year));

        if ($userRating == null) {
            $userRating = new UserRating();
            $userRating->setUser($user);
            $userRating->setYear($year);
            $userRating->setValue($totalUserRating);

            $this->entityManager->persist($userRating);
        } else {
            $userRating->setValue($totalUserRating);
        }

        $this->entityManager->flush();
    }

    /**
     * @param Cathedra $cathedra
     * @param Year $year
     */
    public function calculateRatingForCathedras($cathedra, $year)
    {
        /*** @var CathedraRating $cathedraRating */
        $cathedraRating = $this->entityManager->getRepository('AppBundle:CathedraRating')->findOneBy(array(
            'cathedra' => $cathedra,
            'year' => $year
        ));

        $cathedraCriterionRating = $this->getCriterionRating(3);
        $cathedraUserRating = 0;

        $jobs = $this->entityManager->getRepository('SubdivisionBundle:Job')->findBy(array('cathedra' => $cathedra));
        /** @var Job $teacher */
        foreach ($jobs as $job) {
            $cathedraUserRating += $job->getRating();
        }

        if ($cathedraRating == null) {
            $cathedraRating = new CathedraRating();
            $cathedraRating->setCathedra($cathedra);
            $cathedraRating->setYear($year);
            $cathedraRating->setValue($cathedraCriterionRating + ($cathedraUserRating / $cathedra->getBets()));
            $this->entityManager->persist($cathedraRating);
        } else {
            $cathedraRating->setValue($cathedraCriterionRating + ($cathedraUserRating / $cathedra->getBets()));
        }

        $cathedra->setRating($cathedraRating);
        $this->entityManager->flush();
    }

    /**
     * @param integer $id
     * @return integer
     */
    private function getCriterionRating($id)
    {
        /** @var IntegerType $totalRating */
        $totalRating = 0;

        $categories = $this->entityManager->getRepository('AppBundle:Category')->findBy(array('type' => $id));
        /** @var Category $category */
        foreach ($categories as $category) {
            $criterias = $category->getCriteria();
            /** @var Criterion $criteria */
            foreach ($criterias as $criteria) {
                $measures = $this->entityManager->getRepository('AppBundle:Measure')->findBy(array('criterion' => $criteria));
                /** @var Measure $measure */
                foreach ($measures as $measure) {
                    $totalRating += $measure->getValue();
                }
            }
        }

        return $totalRating;
    }

    /**
     * @param Institute $institute
     * @param Year $year
     */
    public function calculateRatingForInstitute($institute, $year)
    {
        $instituteCriterionRating = $this->getCriterionRating(4);
        $cathedrasRating = 0.0;

        /** @var array $cathedras */
        $cathedras = $this->entityManager->getRepository('SubdivisionBundle:Cathedra')->findBy(array('institute' => $institute));

        /** @var Cathedra $cathedra */
        foreach ($cathedras as $cathedra) {
            /** @var CathedraRating $cRating */
            $cRating = $cathedra->getRating();
            if ($cRating != null) {
                $cathedrasRating += $cRating->getValue();
            }
        }

        $instituteRating = $this->entityManager->getRepository('AppBundle:InstituteRating')->findOneBy(array(
            'institute' => $institute,
            'year' => $year
        ));

        if ($instituteRating == null) {
            $instituteRating = new InstituteRating();
            $instituteRating->setInstitute($institute);
            $instituteRating->setYear($year);
            $instituteRating->setValue($instituteCriterionRating + ($cathedrasRating / count($cathedras)));
            $this->entityManager->persist($instituteRating);
        } else {
            $instituteRating->setValue($instituteCriterionRating + ($cathedrasRating / count($cathedras)));
        }

        $institute->setRating($instituteRating);

        $this->entityManager->flush();
    }

    /***
     * @param Cathedra $cathedra
     * @param Year $year
     */
    public function calculateBetsForCathedra($cathedra, $year)
    {
        $jobs = $this->entityManager->getRepository('SubdivisionBundle:Job')->findBy(array(
            'cathedra' => $cathedra,
            'year' => $year
        ));

        /** @var DecimalType $jBets */
        $jBets = 0;

        /** @var Job $job */
        foreach ($jobs as $job) {
            $jBets += $job->getBet();
        }

        $cathedra->setBets($jBets);
        $this->entityManager->flush();

        $this->calculateBetsForInstitute($cathedra->getInstitute());
    }

    /** @param Institute $institute */
    private function calculateBetsForInstitute($institute)
    {
        $cathedras = $institute->getCathedras();

        /** @var DecimalType $cBets */
        $cBets = 0;

        /** @var Cathedra $cathedra */
        foreach ($cathedras as $cathedra) {
            $cBets += $cathedra->getBets();
        }

        $institute->setBets($cBets);
        $this->entityManager->flush();
    }
}