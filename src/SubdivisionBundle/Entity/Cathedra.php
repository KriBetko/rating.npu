<?php
namespace SubdivisionBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use UserBundle\Entity\User;

/**
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="SubdivisionBundle\Repository\CathedraRepository")
 * @ORM\Table(name="cathedra")
 */
class Cathedra extends Controller
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
     * @ORM\ManyToOne(targetEntity="SubdivisionBundle\Entity\Institute", inversedBy="cathedras")
     * @ORM\JoinColumn(name="institute_id", referencedColumnName="id")
     */
    protected $institute;

    /**
     * @ORM\OneToOne(targetEntity="UserBundle\Entity\User")
     * @ORM\JoinColumn(name="director", referencedColumnName="id")
     */
    protected $director;

    /**
     * @ORM\ManyToMany(targetEntity="UserBundle\Entity\User", inversedBy="cathedras")
     * @ORM\JoinTable(name="cathedras_users")
     */
    protected $managers;

    /**
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\CathedraRating")
     * @ORM\JoinColumn(name="rating", referencedColumnName="id")
     */
    protected $rating;

    /**
     * @ORM\Column(type="decimal", scale=2, nullable=true)
     */
    protected $bets;

    public function __construct()
    {
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
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
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
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
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
     * Get institute
     *
     * @return Institute
     */
    public function getInstitute()
    {
        return $this->institute;
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
     * Get director
     *
     * @return \UserBundle\Entity\User
     */
    public function getDirector()
    {
        return $this->director;
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

    public function getRating()
    {
        return $this->rating;
    }

    public function setRating($rating)
    {
        $this->rating = $rating;
    }

    public function getBets()
    {
        return $this->bets;
    }

    public function setBets($bets)
    {
        $this->bets = $bets;
    }
}
