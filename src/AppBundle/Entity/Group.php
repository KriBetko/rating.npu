<?php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="AppBundle\Repository\GroupRepository")
 * @ORM\Table(name="criteria_group")
 */
class Group
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
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $plural = 1;
    /**
     * @ORM\OneToMany(targetEntity="Criterion", mappedBy="group")
     */
    protected $criteria;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->criteria = new ArrayCollection();
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

    public function isPlural()
    {
        return $this->plural === 2 ? false : true;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return Group
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
     * Add criteria
     *
     * @param \AppBundle\Entity\Criterion $criteria
     * @return Group
     */
    public function addCriterium(Criterion $criteria)
    {
        $this->criteria[] = $criteria;

        return $this;
    }

    /**
     * Remove criteria
     *
     * @param \AppBundle\Entity\Criterion $criteria
     */
    public function removeCriterium(Criterion $criteria)
    {
        $this->criteria->removeElement($criteria);
    }

    /**
     * Get criteria
     *
     * @return ArrayCollection|\Doctrine\Common\Collections\Collection
     */
    public function getCriteria()
    {
        return $this->criteria;
    }
}
