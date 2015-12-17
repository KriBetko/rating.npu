<?php
namespace Rating\SubdivisionBundle\Repository;

use Doctrine\ORM\EntityRepository;


class JobRepository extends EntityRepository
{
    public function findUserJobs($user)
    {
        $em = $this->getEntityManager();
        $qb = $em->createQueryBuilder();
        $qb->add('select', 'j, i, c, p')
            ->from('RatingSubdivisionBundle:Job', 'j')

            ->leftJoin('j.position', 'p')
            ->leftJoin('j.institute', 'i')
            ->leftJoin('j.cathedra', 'c')
            ->where('j.user = :user')
            ->orderBy('j.additional', 'ASC')

            ->setParameters(
                array(
                    'user' => $user
                )
            );
        return $codes = $qb->getQuery()->getResult();
    }
}