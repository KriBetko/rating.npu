<?php
namespace Rating\SubdivisionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="Rating\SubdivisionBundle\Repository\JobRepository")
 * @ORM\Table(name="jobs")
 */
class Job
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="Rating\UserBundle\Entity\User", inversedBy="jobs")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    protected $user;

    /**
     * @ORM\ManyToOne(targetEntity="Position")
     * @ORM\JoinColumn(name="position_id", referencedColumnName="id")
     */
    protected $position;

    /**
     * @ORM\ManyToOne(targetEntity="Cathedra")
     * @ORM\JoinColumn(name="cathedra_id", referencedColumnName="id")
     */
    protected $cathedra;

    /**
     * @ORM\ManyToOne(targetEntity="Institute")
     * @ORM\JoinColumn(name="institute_id", referencedColumnName="id")
     */
    protected $institute;

    /**
     * @ORM\Column(type="decimal", nullable=true)
     */
    protected $bet;

    /**
     * @ORM\Column(type="boolean")
     */
    protected $additional;



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
     * Set bet
     *
     * @param string $bet
     * @return Job
     */
    public function setBet($bet)
    {
        $this->bet = $bet;

        return $this;
    }

    /**
     * Get bet
     *
     * @return string 
     */
    public function getBet()
    {
        return $this->bet;
    }

    /**
     * Set additional
     *
     * @param boolean $additional
     * @return Job
     */
    public function setAdditional($additional)
    {
        $this->additional = $additional;

        return $this;
    }

    /**
     * Get additional
     *
     * @return boolean 
     */
    public function getAdditional()
    {
        return $this->additional;
    }

    /**
     * Set user
     *
     * @param \Rating\UserBundle\Entity\User $user
     * @return Job
     */
    public function setUser(\Rating\UserBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \Rating\UserBundle\Entity\User 
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set position
     *
     * @param \Rating\SubdivisionBundle\Entity\Position $position
     * @return Job
     */
    public function setPosition(\Rating\SubdivisionBundle\Entity\Position $position = null)
    {
        $this->position = $position;

        return $this;
    }

    /**
     * Get position
     *
     * @return \Rating\SubdivisionBundle\Entity\Position 
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * Set cathedra
     *
     * @param \Rating\SubdivisionBundle\Entity\Cathedra $cathedra
     * @return Job
     */
    public function setCathedra(\Rating\SubdivisionBundle\Entity\Cathedra $cathedra = null)
    {
        $this->cathedra = $cathedra;

        return $this;
    }

    /**
     * Get cathedra
     *
     * @return \Rating\SubdivisionBundle\Entity\Cathedra 
     */
    public function getCathedra()
    {
        return $this->cathedra;
    }

    /**
     * Set institute
     *
     * @param \Rating\SubdivisionBundle\Entity\Institute $institute
     * @return Job
     */
    public function setInstitute(\Rating\SubdivisionBundle\Entity\Institute $institute = null)
    {
        $this->institute = $institute;

        return $this;
    }

    /**
     * Get institute
     *
     * @return \Rating\SubdivisionBundle\Entity\Institute 
     */
    public function getInstitute()
    {
        return $this->institute;
    }
}
