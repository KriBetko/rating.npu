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
     * @ORM\OneToOne(targetEntity="Rating\UserBundle\Entity\User")
     * @ORM\JoinColumn(name="director", referencedColumnName="id")
     */
    protected $director;
    /**
     * @ORM\ManyToMany(targetEntity="Rating\UserBundle\Entity\User", inversedBy="institutes")
     * @ORM\JoinTable(name="institutes_users")
     */
    protected $managers;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $description;

    /**
     * @ORM\OneToMany(targetEntity="Cathedra", mappedBy="institute")
     */
    protected $cathedras;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->cathedras = new \Doctrine\Common\Collections\ArrayCollection();
        $this->managers = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @param string $titl
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
     * Set director
     *
     * @param \Rating\UserBundle\Entity\User $director
     * @return Institute
     */
    public function setDirector(\Rating\UserBundle\Entity\User $director = null)
    {
        $this->director = $director;

        return $this;
    }

    /**
     * Get director
     *
     * @return \Rating\UserBundle\Entity\User 
     */
    public function getDirector()
    {
        return $this->director;
    }

    /**
     * Add managers
     *
     * @param \Rating\UserBundle\Entity\User $managers
     * @return Institute
     */
    public function addManager(\Rating\UserBundle\Entity\User $managers)
    {
        $this->managers[] = $managers;

        return $this;
    }

    /**
     * Remove managers
     *
     * @param \Rating\UserBundle\Entity\User $managers
     */
    public function removeManager(\Rating\UserBundle\Entity\User $managers)
    {
        $this->managers->removeElement($managers);
    }

    /**
     * Get managers
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getManagers()
    {
        return $this->managers;
    }
}
