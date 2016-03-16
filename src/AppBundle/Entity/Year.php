<?php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="AppBundle\Repository\YearRepository")
 * @ORM\Table(name="years")
 */
class Year
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    protected $title;

    /**
     * @ORM\Column(type="boolean")
     */
    protected $active;

    /**
     * @ORM\Column(type="boolean")
     */
    protected $editable;

    /**
     * @ORM\ManyToMany(targetEntity="Criterion")
     * @ORM\JoinTable(name="criterion_years",
     *      joinColumns={@ORM\JoinColumn(name="year_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="criterion_id", referencedColumnName="id")}
     *      )
     **/
    protected $criteria;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->criteria = new \Doctrine\Common\Collections\ArrayCollection();
        $this->active = false;
        $this->editable = false;
    }

    /**
     * @return mixed
     */
    public function getEditable()
    {
        return $this->editable;
    }

    /**
     * @param mixed $editable
     */
    public function setEditable($editable)
    {
        $this->editable = $editable;
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
     * Set title
     *
     * @param string $title
     * @return Year
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
     * Set active
     *
     * @param boolean $active
     * @return Year
     */
    public function setActive($active)
    {
        $this->active = $active;

        return $this;
    }

    /**
     * Get active
     *
     * @return boolean 
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * Add criteria
     *
     * @param \AppBundle\Entity\Criterion $criteria
     * @return Year
     */
    public function addCriterium(\AppBundle\Entity\Criterion $criteria)
    {
        $this->criteria[] = $criteria;

        return $this;
    }

    /**
     * Remove criteria
     *
     * @param \AppBundle\Entity\Criterion $criteria
     */
    public function removeCriterium(\AppBundle\Entity\Criterion $criteria)
    {
        $this->criteria->removeElement($criteria);
    }

    /**
     * Get criteria
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getCriteria()
    {
        return $this->criteria;
    }
}
