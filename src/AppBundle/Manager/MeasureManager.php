<?php
namespace AppBundle\Manager;

use AppBundle\Entity\Criterion;
use AppBundle\Entity\Measure;
use AppBundle\Entity\Year;
use Doctrine\ORM\EntityManager;
use SubdivisionBundle\Entity\Job;
use Symfony\Component\DependencyInjection\ContainerInterface as Container;

class MeasureManager
{
    private $em;
    private $container;

    public function __construct(EntityManager $entityManager, Container $container)
    {
        $this->em = $entityManager;
        $this->container = $container;
    }

    public function create(Year $year,Job $job, Criterion $criterion)
    {
        $measure = $this->em->getRepository('AppBundle:Measure')->findOneBy(array(
            'job'      => $job,
            'criterion' => $criterion,
            'year'      => $year)
        );

        if ($measure) return $measure;

        $measure = new Measure();
        $measure->setJob($job);
        $measure->setCriterion($criterion);
        $measure->setYear($year);
        $measure->setValue(0);

        $this->em->persist($measure);
        return $measure;
    }

    public function removeByCriterionIds($ids, $year){
        $this->em->getRepository('AppBundle:Measure')->removeMeasures($ids, $year);
        return true;
    }
    protected function role()
    {

    }
}