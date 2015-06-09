<?php
namespace Rating\SubdivisionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="Rating\SubdivisionBundle\Repository\InstituteRepository")
 * @ORM\Table(name="institute")
 */
class Institute
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
     * @ORM\OneToMany(targetEntity="Cathedra", mappedBy="institute")
     */
    protected $cathedras;
    /**
     * @ORM\OneToMany(targetEntity="Rating\UserBundle\Entity\User", mappedBy="institute")
     */
    protected $users;
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->cathedras = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return Institute
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
     * @return Institute
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
     * Add cathedras
     *
     * @param \Rating\SubdivisionBundle\Entity\Cathedra $cathedras
     * @return Institute
     */
    public function addCathedra(\Rating\SubdivisionBundle\Entity\Cathedra $cathedras)
    {
        $this->cathedras[] = $cathedras;

        return $this;
    }

    /**
     * Remove cathedras
     *
     * @param \Rating\SubdivisionBundle\Entity\Cathedra $cathedras
     */
    public function removeCathedra(\Rating\SubdivisionBundle\Entity\Cathedra $cathedras)
    {
        $this->cathedras->removeElement($cathedras);
    }

    /**
     * Get cathedras
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getCathedras()
    {
        return $this->cathedras;
    }

    /**
     * Add users
     *
     * @param \Rating\UserBundle\Entity\User $users
     * @return Institute
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
