<?php

namespace UserBundle\Entity;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\IntegerType;
use Doctrine\ORM\Mapping as ORM;
use SubdivisionBundle\Entity\Cathedra;
use SubdivisionBundle\Entity\Institute;
use SubdivisionBundle\Entity\Job;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="UserBundle\Repository\UserRepository")
 * @ORM\Table(name="user")
 *
 */
class User implements UserInterface, \Serializable
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    /**
     * @ORM\Column(type="string", length=255)
     *
     * @Assert\NotBlank(message="Будь ласка, введіть Ваше ім'я.", groups={"Registration", "Profile"})
     * @Assert\Length(
     *     min=3,
     *     max="255",
     *     minMessage="Ім'я занадто коротке.",
     *     maxMessage="Ім'я занадто довге.",
     *     groups={"Registration", "Profile", "Registration", "Profile"}
     * )
     */
    protected $firstName;
    /**
     * @ORM\Column(type="string", length=255)
     *
     * @Assert\NotBlank(message="Будь ласка, введіть Ваше прізвище.", groups={"Registration", "Profile"})
     * @Assert\Length(
     *     min=3,
     *     max="255",
     *     minMessage="Прізвище занадто коротке.",
     *     maxMessage="Прізвище занадто довге.",
     *     groups={"Registration", "Profile", "Registration", "Profile"}
     * )
     */
    protected $lastName;
    /**
     * @ORM\Column(type="string", length=255)
     *
     * @Assert\NotBlank(message="Будь ласка, введіть Ваше по-батькові.", groups={"Registration", "Profile"})
     * @Assert\Length(
     *     min=3,
     *     max="255",
     *     minMessage="Мінімальна кількість символів - 3",
     *     maxMessage="Максимальна кількість символів - 255.",
     *     groups={"Registration", "Profile", "Registration", "Profile"}
     * )
     */
    protected $parentName;
    /**
     * @ORM\Column(type="string", length=512, nullable=true)
     *
     */
    protected $picture;
    /**
     * @ORM\Column(type="datetime", length=255, nullable=true)
     */
    protected $birthday;
    /**
     * @ORM\OneToMany(targetEntity="SubdivisionBundle\Entity\Job", mappedBy="user")
     */
    protected $jobs;
    /**
     * @ORM\Column(type="string", nullable=true, length=256)
     */
    protected $googleId;
    /**
     * @ORM\Column(type="string", length=255, unique=true)
     * @Assert\NotBlank()
     * @Assert\Email()
     */
    private $email;
    /**
     * @ORM\Column(name="roles", type="array")
     */
    private $roles;
    /**
     * @ORM\Column(type="integer")
     */
    private $rating = 0;
    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $availableYearId;
    /**
     * @ORM\ManyToMany(targetEntity="SubdivisionBundle\Entity\Institute", mappedBy="managers")
     */
    private $institutes;
    /**
     * @ORM\ManyToMany(targetEntity="SubdivisionBundle\Entity\Cathedra", mappedBy="managers")
     */
    private $cathedras;

    public function __construct()
    {
        $this->jobs = new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getPicture()
    {
        return $this->picture;
    }

    /**
     * @param mixed $picture
     */
    public function setPicture($picture)
    {
        $this->picture = $picture;
    }

    /**
     * @return mixed
     */
    public function getGoogleId()
    {
        return $this->googleId;
    }

    /**
     * @param mixed $googleId
     */
    public function setGoogleId($googleId)
    {
        $this->googleId = $googleId;
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
     * Add jobs
     *
     * @param Job $jobs
     * @return User
     */
    public function addJob(Job $jobs)
    {
        $this->jobs[] = $jobs;

        return $this;
    }

    /**
     * Remove jobs
     *
     * @param Job $jobs
     */
    public function removeJob(Job $jobs)
    {
        $this->jobs->removeElement($jobs);
    }

    /**
     * Get jobs
     *
     * @return Collection
     */
    public function getJobs()
    {
        return $this->jobs;
    }

    /**
     * Get birthday
     *
     * @return DateTime
     */
    public function getBirthday()
    {
        return $this->birthday;
    }

    /**
     * Set birthday
     *
     * @param DateTime $birthday
     * @return User
     */
    public function setBirthday($birthday)
    {
        $this->birthday = $birthday;

        return $this;
    }

    /**
     * Add institutes
     *
     * @param Institute $institutes
     * @return User
     */
    public function addInstitute(Institute $institutes)
    {
        $this->institutes[] = $institutes;

        return $this;
    }

    /**
     * Remove institutes
     *
     * @param Institute $institutes
     */
    public function removeInstitute(Institute $institutes)
    {
        $this->institutes->removeElement($institutes);
    }

    /**
     * Get institutes
     *
     * @return Collection
     */
    public function getInstitutes()
    {
        return $this->institutes;
    }

    /**
     * Add cathedras
     *
     * @param Cathedra $cathedras
     * @return User
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

    public function __toString()
    {
        return $this->getLastName() . ' ' . $this->getFirstName() . ' ' . $this->getParentName();
    }

    /**
     * Get lastName
     *
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Set lastName
     *
     * @param string $lastName
     * @return User
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * Get firstName
     *
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set firstName
     *
     * @param string $firstName
     * @return User
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Get parentName
     *
     * @return string
     */
    public function getParentName()
    {
        return $this->parentName;
    }

    /**
     * Set parentName
     *
     * @param string $parentName
     * @return User
     */
    public function setParentName($parentName)
    {
        $this->parentName = $parentName;

        return $this;
    }

    public function getSalt()
    {
        return null;
    }

    public function getUsername()
    {
        return $this->getEmail();
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getPassword()
    {
        return null;
    }

    public function eraseCredentials()
    {
        return null;
    }

    /** @see \Serializable::serialize() */
    public function serialize()
    {
        return serialize(array(
            $this->id,
            $this->email,
            $this->googleId,
            $this->parentName,
            $this->lastName,
            $this->firstName
            // see section on salt below
            // $this->salt,
        ));
    }

    /** @see \Serializable::unserialize()
     * @param string $serialized
     */
    public function unserialize($serialized)
    {
        list (
            $this->id,
            $this->email,
            $this->googleId,
            $this->parentName,
            $this->lastName,
            $this->firstName
            // see section on salt below
            // $this->salt
            ) = unserialize($serialized);
    }

    public function addRole($role)
    {
        $this->roles[] = $role;
        return $this;
    }

    public function removeRole($role)
    {
        $this->roles[] = $role;
        foreach ($this->roles as $k => $v) {
            if ($role == $v) {
                unset($this->roles[$k]);
            }
        }
        return $this;
    }

    public function isStudent()
    {
        if (in_array("ROLE_STUDENT", $this->getRoles())) {
            return true;
        }
        return false;
    }

    public function getRoles()
    {
        return $this->roles;
    }

    /**
     * Set roles
     *
     * @param array $roles
     *
     * @return User
     */
    public function setRoles($roles)
    {
        $this->roles = $roles;

        return $this;
    }

    public function isTeacher()
    {
        if (in_array("ROLE_TEACHER", $this->getRoles())) {
            return true;
        }
        return false;
    }

    public function isAdmin()
    {
        if (in_array("ROLE_ADMIN", $this->getRoles())) {
            return true;
        }
        return false;
    }

    public function getRating()
    {
        return $this->rating;
    }

    /**
     * @param IntegerType $rating
     * @return $this
     */
    public function setRating($rating)
    {
        $this->rating = $rating;
        return $this;
    }

    public function isBlock()
    {
        return $this->availableYearId == null;
    }

    /**
     * @return integer
     */
    public function getAvailableYear()
    {
        return $this->availableYearId;
    }

    /**
     * @param $yearId
     * @return $this
     */
    public function setAvailableYeaR($yearId)
    {
        $this->availableYearId = $yearId;
        return $this;
    }
}
