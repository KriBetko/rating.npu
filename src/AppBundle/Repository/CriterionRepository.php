<?php
namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

class CriterionRepository extends EntityRepository
{
    public function findGrouped()
    {
        $qb = $this->createQueryBuilder('c');
        $qb->select('c')
            ->orderBy('c.category', 'ASC')
            ->orderBy('c.group', 'ASC');

        return $qb->getQuery()->getResult();

    }
}