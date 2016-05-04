<?php
namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;
use FOS\UserBundle\Model\User;

class MeasureRepository extends EntityRepository
{
    public function getGroupedMeasure($measure)
    {
        $qb = $this->createQueryBuilder('m');
        $qb
            ->select('m')
            ->join('m.criterion', 'c')
            ->join('c.group', 'g')
            ->where('g.id = :mGroup')
            ->andWhere('m.job = :job')
            ->andWhere('m.year = :year')
            ->andWhere('m.id != :id')
            ->andWhere('m.value > 0')
            ->setParameters(
                [
                    'mGroup' =>  $measure->getCriterion()->getGroup()->getId(),
                    'job'   => $measure->getJob(),
                    'year'  => $measure->getYear(),
                    'id'    => $measure->getId()
                ]);
        return $qb->getQuery()->getResult();

    }


    public function removeMeasures($ids, $year){
        $q = $this->getEntityManager()->createQuery('
                DELETE FROM AppBundle:Measure m
                WHERE m.criterion IN (:ids) AND m.year = :year'
        );
        $q->setParameter('ids', $ids);
        $q->setParameter('year', $year);
        $q->execute();
    }

    public function getValue($cathedra)
    {
        $em = $this->getEntityManager();
        $query = $em->createQuery('SELECT  u.firstName AS fname, u.lastName AS lname, u.parentName AS pname, SUM (m.result) AS summa, u.id AS id
                                   FROM \AppBundle\Entity\Measure m
                                        LEFT JOIN \Rating\SubdivisionBundle\Entity\Job j WITH (j.id = m.job)
                                        JOIN \Rating\UserBundle\Entity\User u WITH (j.user = u.id)
                                        JOIN \Rating\SubdivisionBundle\Entity\Cathedra c WITH (j.cathedra = c.id)
                                        WHERE c.id= :cathedra
                                        GROUP BY u.id
                                    ');
        $query->setParameters(array('cathedra' => $cathedra->getId()));
        $result =  $query->getResult();
        return $result;
    }

    public function getUserMeasures($year, $user)
    {
        $em = $this->getEntityManager();
        $jobQuery =  $em->createQuery('SELECT  j
                                   FROM Rating\SubdivisionBundle\Entity\Job j
                                   WHERE j.user = :user
                                   ORDER BY j.additional ASC

                                    ');
        $jobQuery->setParameters(array('user' => $user));
        $jobResult =  $jobQuery->getResult();

        $query = $em->createQuery('SELECT  g.id AS group_id, g.title as group_title,
                                           cr.id AS criteria_id, cr.title AS criteria_title, cr.coefficient AS criteria_coefficient,
                                           ca.id AS category_id, ca.title AS category_title, j.id AS job, m
                                   FROM \AppBundle\Entity\Measure m
                                   LEFT JOIN \AppBundle\Entity\Criterion cr WITH (cr.id = m.criterion)
                                   LEFT JOIN \AppBundle\Entity\Group g WITH (cr.group = g.id)
                                   LEFT JOIN \AppBundle\Entity\Year y WITH (y.id = m.year)
                                   LEFT JOIN \Rating\SubdivisionBundle\Entity\Job j WITH (j.id = m.job)
                                   LEFT JOIN \AppBundle\Entity\Category ca WITH (ca.id = cr.category)
                                   WHERE j.user = :user AND m.year = :year

                                    ');
        $query->setParameters(array('user' => $user, 'year' => $year));
        $result =  $query->getResult();
        $return = array();

        foreach ($jobResult as $job) {
            $groups = array();
            $groups['ids'] =array();
            $categories = array();
            $categories_ids = array();
            foreach ($result as $r) {
                if ($job->getId() == $r['job']){
                    $id = $r['category_id'];
                    $group_id = $r['group_id'];
                    if (!in_array($r['category_id'], $categories_ids)){
                        $categories_ids[] = $id;
                        $categories[$id]['title'] = $r['category_title'];
                        $categories[$id]['category_id'] = $id;
                    }
                    if ((!in_array($group_id, $groups['ids']) || null !== $group_id) && null !== $group_id) {
                        $groups['ids'][] = $group_id;
                        $categories[$id]['grouped'][$group_id]['title'] = $r['group_title'];
                        $categories[$id]['grouped'][$group_id]['singles'][] = array(
                            'measure' => $r[0],
                            'criteria_id' => $r['criteria_id'],
                            'criteria_title' => $r['criteria_title'],
                            'criteria_coefficient' => $r['criteria_coefficient']
                        );
                    } else {
                        $categories[$id]['singles'][] = array(
                            'measure' => $r[0],
                            'criteria_id' => $r['criteria_id'],
                            'criteria_title' => $r['criteria_title'],
                            'criteria_coefficient' => $r['criteria_coefficient']
                        );
                    }
                }

            }
            $return[] = array('job' => $job,'categories' => $categories);

        }
        return $return;
    }


}