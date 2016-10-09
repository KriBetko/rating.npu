<?php
namespace SubdivisionBundle\Repository;

use Doctrine\ORM\EntityRepository;

class InstituteRepository extends EntityRepository
{
    public function findAllByRating()
    {
        return $this->findBy(array(), array('rating' => 'DESC'));
    }
}