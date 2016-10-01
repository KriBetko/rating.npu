<?php
namespace SubdivisionBundle\Repository;

use Doctrine\ORM\EntityRepository;

class JobRepository extends EntityRepository
{
    public function findUserJobs($user)
    {
        $em = $this->getEntityManager();
        $qb = $em->createQueryBuilder();
        $qb->add('select', 'j, i, c, p')
            ->from('SubdivisionBundle:Job', 'j')

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

    public function createJobQuery()
    {
        $qb = $this->createQueryBuilder('j');
        $qb
            ->select('j')
            ->where('j.formEducation is null');

        $result = $qb->getQuery()->getResult();
        dump($result);die;
    }

    public function getGroupList()
    {
        $result = $this->_em->createQuery("SELECT DISTINCT j.group FROM SubdivisionBundle:Job j  WHERE j.group IS NOT NULL")->getScalarResult();
        $groups = array_map('current', $result);
       return $groups;
    }
}