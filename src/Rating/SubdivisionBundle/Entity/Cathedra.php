<?php
namespace Rating\SubdivisionBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Rating\UserBundle\Entity\User;

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
     * @ORM\Column(type="text", nullable=true)
     */
    protected $description;

    /**
     * @ORM\ManyToOne(targetEntity="Rating\SubdivisionBundle\Entity\Institute", inversedBy="cathedras")
     * @ORM\JoinColumn(name="institute_id", referencedColumnName="id")
     */
    protected $institute;

    /**
     * @ORM\OneToOne(targetEntity="Rating\UserBundle\Entity\User")
     * @ORM\JoinColumn(name="director", referencedColumnName="id")
     */
    protected $director;

    /**
     * @ORM\ManyToMany(targetEntity="Rating\UserBundle\Entity\User", inversedBy="cathedras")
     * @ORM\JoinTable(name="cathedras_users")
     */
    protected $managers;

    public function __construct()
    {
        $this->managers = new ArrayCollection();
        $this->users = new ArrayCollection();
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
     * @param Institute $institute
     * @return Cathedra
     */
    public function setInstitute(Institute $institute = null)
    {
        $this->institute = $institute;

        return $this;
    }

    /**
     * Get institute
     *
     * @return Institute
     */
    public function getInstitute()
    {
        return $this->institute;
    }


    /**
     * Add users
     *
     * @param User $users
     * @return Cathedra
     */
    public function addUser(User $users)
    {
        $this->users[] = $users;

        return $this;
    }

    /**
     * Remove users
     *
     * @param User $users
     */
    public function removeUser(User $users)
    {
        $this->users->removeElement($users);
    }

    /**
     * Get users
     *
     * @return ArrayCollection|Collection
     */
    public function getUsers()
    {
        return $this->users;
    }

    /**
     * Set director
     *
     * @param User $director
     * @return Cathedra
     */
    public function setDirector(User $director = null)
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
     * @param User $managers
     * @return Cathedra
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
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getManagers()
    {
        return $this->managers;
    }
}
