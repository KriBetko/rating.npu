<?php
namespace SubdivisionBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\DecimalType;
use Doctrine\ORM\Mapping as ORM;
use UserBundle\Entity\User;

/**
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="SubdivisionBundle\Repository\InstituteRepository")
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
     * @ORM\OneToOne(targetEntity="UserBundle\Entity\User")
     * @ORM\JoinColumn(name="director", referencedColumnName="id")
     */
    protected $director;

    /**
     * @ORM\ManyToMany(targetEntity="UserBundle\Entity\User", inversedBy="institutes")
     * @ORM\JoinTable(name="institutes_users")
     */
    protected $managers;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $description;

    /**
     * @ORM\OneToMany(targetEntity="SubdivisionBundle\Entity\Cathedra", mappedBy="institute")
     * @ORM\OrderBy({"rating" = "DESC"})
     */
    protected $cathedras;

    /**
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\InstituteRating")
     * @ORM\JoinColumn(name="rating", referencedColumnName="id")
     */
    protected $rating;

    /**
     * @ORM\Column(type="decimal")
     */
    protected $bets;

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
     * @return Institute
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
     * @return Institute
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
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
     * Get director
     *
     * @return User
     */
    public function getDirector()
    {
        return $this->director;
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

    public function getRating()
    {
        return $this->rating;
    }

    public function setRating($rating)
    {
        $this->rating = $rating;
    }

    /**
     * @return DecimalType
     */
    public function getBets()
    {
        return $this->bets;
    }

    /**
     * @param DecimalType $bets
     */
    public function setBets($bets)
    {
        $this->bets = $bets;
    }
}
