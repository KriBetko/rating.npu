<?php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="AppBundle\Repository\MeasureRepository")
 * @ORM\Table(name="measures")
 */
class Measure
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="Rating\SubdivisionBundle\Entity\Job")
     * @ORM\JoinColumn(name="job_id", referencedColumnName="id", onDelete="CASCADE")
     */
    protected $job;

    /**
     * @ORM\Column(type="integer")
     */
    protected $value;

    /**
     * @ORM\ManyToOne(targetEntity="Criterion")
     * @ORM\JoinColumn(name="criterion_id", referencedColumnName="id")
     */
    protected $criterion;

    /**
     * @ORM\ManyToOne(targetEntity="Year")
     * @ORM\JoinColumn(name="year_id", referencedColumnName="id")
     */
    protected $year;

    /**
     * @ORM\OneToMany(targetEntity="Field", mappedBy="measure", cascade={"persist"})
     */
    protected $fields;

    /**
     * @return mixed
     */
    public function getResult()
    {
        return $this->result;
    }

    /**
     * @param mixed $result
     */
    public function setResult($result)
    {
        $this->result = $result;
    }

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    protected $result = 0;
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fields = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set value
     *
     * @param integer $value
     * @return Measure
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get value
     *
     * @return integer 
     */
    public function getValue()
    {
        return $this->value;
    }


    /**
     * Set criterion
     *
     * @param \AppBundle\Entity\Criterion $criterion
     * @return Measure
     */
    public function setCriterion(\AppBundle\Entity\Criterion $criterion = null)
    {
        $this->criterion = $criterion;

        return $this;
    }

    /**
     * Get criterion
     *
     * @return \AppBundle\Entity\Criterion 
     */
    public function getCriterion()
    {
        return $this->criterion;
    }

    /**
     * Set year
     *
     * @param \AppBundle\Entity\Year $year
     * @return Measure
     */
    public function setYear(\AppBundle\Entity\Year $year = null)
    {
        $this->year = $year;

        return $this;
    }

    /**
     * Get year
     *
     * @return \AppBundle\Entity\Year 
     */
    public function getYear()
    {
        return $this->year;
    }

    /**
     * Add fields
     *
     * @param \AppBundle\Entity\Field $fields
     * @return Measure
     */
    public function addField(\AppBundle\Entity\Field $fields)
    {
        $fields->setMeasure($this);
        $this->fields->add($fields);

        return $this;
    }

    /**
     * Remove fields
     *
     * @param \AppBundle\Entity\Field $fields
     */
    public function removeField(\AppBundle\Entity\Field $fields)
    {
        $this->fields->removeElement($fields);
    }

    /**
     * Get fields
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getFields()
    {
        return $this->fields;
    }

    /**
     * Set job
     *
     * @param \Rating\SubdivisionBundle\Entity\Job $job
     * @return Measure
     */
    public function setJob(\Rating\SubdivisionBundle\Entity\Job $job = null)
    {
        $this->job = $job;

        return $this;
    }

    /**
     * Get job
     *
     * @return \Rating\SubdivisionBundle\Entity\Job 
     */
    public function getJob()
    {
        return $this->job;
    }
}
