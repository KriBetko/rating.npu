<?php
namespace Rating\SubdivisionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="Rating\SubdivisionBundle\Repository\CathedraRepository")
 * @ORM\Table(name="cathedra")
 */
class Cathedra
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
     * @ORM\Column(type="text")
     */
    protected $description;

    /**
     * @ORM\ManyToOne(targetEntity="Institute", inversedBy="cathedras")
     * @ORM\JoinColumn(name="institute_id", referencedColumnName="id")
     */
    protected $institute;


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
     * @return Cathedra
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
     * Set description
     *
     * @param string $description
     * @return Cathedra
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set institute
     *
     * @param \Rating\SubdivisionBundle\Entity\Institute $institute
     * @return Cathedra
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
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->users = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add users
     *
     * @param \Rating\UserBundle\Entity\User $users
     * @return Cathedra
     */
    public function addUser(\Rating\UserBundle\Entity\User $users)
    {
        $this->users[] = $users;

        return $this;
    }

    /**
     * Remove users
     *
     * @param \Rating\UserBundle\Entity\User $users
     */
    public function removeUser(\Rating\UserBundle\Entity\User $users)
    {
        $this->users->removeElement($users);
    }

    /**
     * Get users
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getUsers()
    {
        return $this->users;
    }
}
