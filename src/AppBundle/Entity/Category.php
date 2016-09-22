<?php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CategoryRepository")
 * @ORM\Table(name="criteria_category")
 */
class Category
{
    const TYPE_TEACHER      = 1;
    const TYPE_STUDENT      = 2;
    const TYPE_CATHEDRA     = 3;
    const TYPE_INSTITUTE    = 4;


    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $title;

    /**
     * @ORM\Column(name="criterion_type", type="integer")
     */
    protected $type;

    /**
     * @ORM\OneToMany(targetEntity="Criterion", mappedBy="category")
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
     * Set title
     *
     * @param string $title
     * @return Category
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
     * Set type
     *
     * @param integer $type
     * @return Category
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
     * Add criteria
     *
     * @param \AppBundle\Entity\Criterion $criteria
     * @return Category
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
    public function getTextType()
    {
        switch($this->type)
        {
            case self::TYPE_TEACHER:
                return "Для викладачів";
            case self::TYPE_STUDENT:
                return "Для студнетів";
            case self::TYPE_CATHEDRA:
                return "Для кафедри";
            case self::TYPE_INSTITUTE:
                return "Для факультету";
            default:
                return "Не обрано";
        }
    }
}
