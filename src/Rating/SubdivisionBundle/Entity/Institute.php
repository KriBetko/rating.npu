<?php
namespace Rating\SubdivisionBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Rating\UserBundle\Entity\User;

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
     * @ORM\OneToOne(targetEntity="User)
     * @ORM\JoinColumn(name="director", referencedColumnName="id")
     */
    protected $director;
    /**
     * @ORM\ManyToMany(targetEntity="User", inversedBy="institutes")
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
        $this->cathedras = new ArrayCollection();
        $this->managers = new ArrayCollection();
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
     * @param Cathedra $cathedras
     * @return Institute
     */
    public function addCathedra(Cathedra $cathedras)
    {
        $this->cathedras[] = $cathedras;

        return $this;
    }

    /**
     * Remove cathedras
     *
     * @param Cathedra $cathedras
     */
    public function removeCathedra(Cathedra $cathedras)
    {
        $this->cathedras->removeElement($cathedras);
    }

    /**
     * Get cathedras
     *
     * @return Collection
     */
    public function getCathedras()
    {
        return $this->cathedras;
    }


    /**
     * Set director
     *
     * @param User $director
     * @return Institute
     */
    public function setDirector(User $director = null)
    {
        $this->director = $director;

        return $this;
    }

    /**
     * Get director
     *
     * @return User
     */
    public function getDirector()
    {
        return $this->director;
    }

    /**
     * Add managers
     *
     * @param User $managers
     * @return Institute
     */
    public function addManager(User $managers)
    {
        $this->managers[] = $managers;

        return $this;
    }

    /**
     * Remove managers
     *
     * @param User $managers
     */
    public function removeManager(User $managers)
    {
        $this->managers->removeElement($managers);
    }

    /**
     * Get managers
     *
     * @return Collection
     */
    public function getManagers()
    {
        return $this->managers;
    }
}
