<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CategoryRepository")
 * @ORM\Table(name="rating_institutes")
 */
class InstituteRating
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="SubdivisionBundle\Entity\Institute")
     * @ORM\JoinColumn(name="institute_id", referencedColumnName="id")
     */
    protected $institute;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Year")
     * @ORM\JoinColumn(name="year_id", referencedColumnName="id")
     */
    protected $year;

    /**
     * @ORM\Column(type="decimal")
     */
    protected $value = 0.0;

    /**
     * @ORM\Column(type="integer")
     */
    protected $ratingPosition = 0;

    /**
     * @return mixed
     */
    public function getInstitute()
    {
        return $this->institute;
    }

    /**
     * @param $institute
     */
    public function setInstitute($institute)
    {
        $this->institute = $institute;
    }

    /**
     * @return mixed
     */
    public function getYear()
    {
        return $this->year;
    }

    /**
     * @param $year
     */
    public function setYear($year)
    {
        $this->year = $year;
    }

    /**
     * @return int
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param $value
     */
    public function setValue($value)
    {
        $this->value = $value;
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return integer
     */
    public function getRatingPosition()
    {
        return $this->ratingPosition;
    }

    /**
     * @param integer $ratingPosition
     */
    public function setRatingPosition($ratingPosition)
    {
        $this->ratingPosition = $ratingPosition;
    }
}