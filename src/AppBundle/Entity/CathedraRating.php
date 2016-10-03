<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CategoryRepository")
 * @ORM\Table(name="rating_cathedras")
 */
class CathedraRating
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="SubdivisionBundle\Entity\Cathedra")
     * @ORM\JoinColumn(name="cathedra_id", referencedColumnName="id")
     */
    protected $cathedra;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Year")
     * @ORM\JoinColumn(name="year_id", referencedColumnName="id")
     */
    protected $year;

    /**
     * @ORM\Column(type="integer")
     */
    protected $value = 0;

    /**
     * @return mixed
     */
    public function getCathedra()
    {
        return $this->cathedra;
    }

    /**
     * @param $cathedra
     */
    public function setCathedra($cathedra)
    {
        $this->cathedra = $cathedra;
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
}