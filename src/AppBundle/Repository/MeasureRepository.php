<?php
namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;
use FOS\UserBundle\Model\User;

class MeasureRepository extends EntityRepository
{
    public function removeMeasures($ids, $year){
        $q = $this->getEntityManager()->createQuery('
                DELETE FROM AppBundle:Measure m
                WHERE m.criterion IN (:ids) AND m.year = :year'
        );
        $q->setParameter('ids', $ids);
        $q->setParameter('year', $year);
        $q->execute();
    }

    public function getUserMeasures($year, $user)
    {
        $em = $this->getEntityManager();
        $query = $em->createQuery('SELECT  g.id AS group_id, g.title as group_title,
                                           cr.id AS criteria_id, cr.title AS criteria_title, cr.coefficient AS criteria_coefficient,
                                           ca.id AS category_id, ca.title AS category_title,
                                           m
                                   FROM \AppBundle\Entity\Measure m
                                   LEFT JOIN \AppBundle\Entity\Criterion cr WITH (cr.id = m.criterion)
                                   LEFT JOIN \AppBundle\Entity\Group g WITH (cr.group = g.id)
                                   LEFT JOIN \AppBundle\Entity\Year y WITH (y.id = m.year)
                                   LEFT JOIN \Rating\UserBundle\Entity\User u WITH (u.id = m.user)
                                   LEFT JOIN \AppBundle\Entity\Category ca WITH (ca.id = cr.category)
                                   WHERE m.user = :user AND m.year = :year

                                    ');
        $query->setParameters(array('user' => $user, 'year' => $year));
        $result =  $query->getResult();

        $groups = array();
        $groups['ids'] =array();
        $categories = array();
        $categories_ids = array();

        foreach ($result as $r) {
            $id = $r['category_id'];
            $group_id = $r['group_id'];
            if (!in_array($r['category_id'], $categories_ids)){
                $categories_ids[] = $id;
                $categories[$id]['title'] = $r['category_title'];
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

        return $categories;
    }


}