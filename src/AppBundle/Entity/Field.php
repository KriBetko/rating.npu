<?php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="AppBundle\Repository\FieldRepository")
 * @ORM\Table(name="fields")
 */
class Field
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
     * @ORM\ManyToOne(targetEntity="Measure", inversedBy="fields", cascade={"persist"})
     * @ORM\JoinColumn(name="measure_id", referencedColumnName="id", onDelete="CASCADE")
     */
    protected $measure;


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
     * @return Field
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
     * Set measure
     *
     * @param \AppBundle\Entity\Measure $measure
     * @return Field
     */
    public function setMeasure(\AppBundle\Entity\Measure $measure = null)
    {
        $this->measure = $measure;

        return $this;
    }

    /**
     * Get measure
     *
     * @return \AppBundle\Entity\Measure 
     */
    public function getMeasure()
    {
        return $this->measure;
    }
}
