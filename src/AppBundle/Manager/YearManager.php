<?php
namespace AppBundle\Manager;

use AppBundle\Entity\Category;
use AppBundle\Entity\Year;
use Doctrine\ORM\EntityManager;
use Symfony\Component\DependencyInjection\ContainerInterface as Container;

class YearManager
{
    private $em;
    private $container;

    public function __construct(EntityManager $entityManager, Container $container)
    {
        $this->em = $entityManager;
        $this->container = $container;
    }

    public function generateMeasureForAllUser(Year $year, $user = false)
    {
        $measureManager = $this->container->get('measure');
        $repository = $this->em->getRepository('SubdivisionBundle:Job');
        $jobs = ($user) ? $repository->findBy(['user' => $user]) : $repository->findAll();
        $criteria = $year->getCriteria()->toArray();
        $this->clearDeletedMeasureForAllUser($year, $criteria);
        foreach ($criteria as $criterion) {
            foreach ($jobs as $job) {
                if (($job->getGroup() !== null && $criterion->getCategory()->getType() == Category::TYPE_STUDENT) ||
                    ($job->getGroup() == null && $criterion->getCategory()->getType() == Category::TYPE_TEACHER)
                )
                    $measureManager->create($year, $job, $criterion);
            }
            $this->em->flush();
        }
        return true;
    }


    private function clearDeletedMeasureForAllUser($year, $criteria)
    {

        $allCriteria = $this->em->getRepository('AppBundle:Criterion')->findAll();
        $results = array_diff($allCriteria, $criteria);
        if (!$results) return false;
        $this->container->get('measure')->removeByCriterionIds($results, $year);
        return true;

    }

    public function getCurrentYear()
    {
        return $this->em->getRepository('AppBundle:Year')->findOneByActive(true);
    }

    public function getYears()
    {
        return $this->em->getRepository('AppBundle:Year')->findBy([], ['title' => 'DESC']);
    }
}