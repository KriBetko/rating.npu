<?php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CriterionRepository")
 * @ORM\Table(name="criteria")
 */
class Criterion
{
    const T_PLURAL      =   1;
    const T_UNITARY     =   2;
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="text")
     */
    protected $title;

    /**
     * @ORM\Column(type="decimal", scale=2, nullable=true)
     */
    protected $coefficient;

    /**
     * @ORM\Column(type="string", nullable=true, length=100)
     */
    protected $reference;

    /**
     * @ORM\Column(type="integer")
     */
    protected $type = 1;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $plural = 1;

    /**
     * @ORM\ManyToOne(targetEntity="Category", inversedBy="criteria")
     * @ORM\JoinColumn(name="category_id", referencedColumnName="id")
     */
    protected $category;

    /**
     * @ORM\ManyToOne(targetEntity="Group", inversedBy="criteria")
     * @ORM\JoinColumn(name="group_id", referencedColumnName="id")
     */
    protected $group;

    public function __toString(){
        try {
            return (string) $this->id;
        } catch (Exception $exception) {
            return '';
        }
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
    public function isPlural()
    {
        return $this->plural === 2 ? false : true;
    }


    /**
     * @return mixed
     */
    public function getPlural()
    {
        return $this->plural;
    }

    /**
     * @param mixed $plural
     */
    public function setPlural($plural)
    {
        $this->plural = $plural;
    }



    /**
     * Set title
     *
     * @param string $title
     * @return Criterion
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set coefficient
     *
     * @param string $coefficient
     * @return Criterion
     */
    public function setCoefficient($coefficient)
    {
        $this->coefficient = $coefficient;

        return $this;
    }

    /**
     * Get coefficient
     *
     * @return string 
     */
    public function getCoefficient()
    {
        return $this->coefficient;
    }

    /**
     * Set reference
     *
     * @param string $reference
     * @return Criterion
     */
    public function setReference($reference)
    {
        $this->reference = $reference;

        return $this;
    }

    /**
     * Get reference
     *
     * @return string 
     */
    public function getReference()
    {
        return $this->reference;
    }

    /**
     * Set type
     *
     * @param integer $type
     * @return Criterion
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return integer 
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set category
     *
     * @param \AppBundle\Entity\Category $category
     * @return Criterion
     */
    public function setCategory(\AppBundle\Entity\Category $category = null)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return \AppBundle\Entity\Category 
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Set group
     *
     * @param \AppBundle\Entity\Group $group
     * @return Criterion
     */
    public function setGroup(\AppBundle\Entity\Group $group = null)
    {
        $this->group = $group;

        return $this;
    }

    /**
     * Get group
     *
     * @return \AppBundle\Entity\Group 
     */
    public function getGroup()
    {
        return $this->group;
    }
}
