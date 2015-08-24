<?php
namespace AppBundle\Manager;

use AppBundle\Entity\Year;
use Doctrine\ORM\EntityManager;
use Rating\UserBundle\Entity\User;
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
    public function generateMeasureForAllUser(Year $year)
    {
        $measureManager = $this->container->get('measure');
        $users = $this->em->getRepository('RatingUserBundle:User')->findAll();
        $criteria = $year->getCriteria()->toArray();
        $this->clearDeletedMeasureForAllUser($year, $criteria);
        foreach ($criteria as $criterion) {
            foreach ($users as $user) {
                $measureManager->create($year, $user, $criterion);
            }
            $this->em->flush();
        }
        return true;
    }


    private function clearDeletedMeasureForAllUser($year, $criteria){

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
}