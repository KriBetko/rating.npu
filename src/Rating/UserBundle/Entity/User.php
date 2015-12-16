<?php

namespace Rating\UserBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass="Rating\UserBundle\Repository\UserRepository")
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
     * @ORM\Column(type="string", length=255, nullable=true)
     *
     */
    protected $firstName;
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     *
     */
    protected $lastName;
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     *
     */
    protected $parentName;

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
     * @ORM\Column(type="string", length=512, nullable=true)
     *
     */
    protected $picture;

    /**
     * @ORM\Column(type="datetime", length=255, nullable=true)
    */
    protected $birthday;

    /**
     * @ORM\OneToMany(targetEntity="Rating\SubdivisionBundle\Entity\Job", mappedBy="user")
     */
    protected $jobs;

    /**
     * @ORM\Column(type="string", nullable=true, length=256)
     */
    protected $googleId;

    /**
     * @return mixed
     */
    public function getGoogleId()
    {
        return $this->googleId;
    }

    public function __construct()
    {
        $this->jobs = new ArrayCollection();
    }
    /**
     * @param mixed $googleId
     */
    public function setGoogleId($googleId)
    {
        $this->googleId = $googleId;
    }

    /**
     * @ORM\ManyToMany(targetEntity="Rating\SubdivisionBundle\Entity\Institute", mappedBy="managers")
     */
    private $institutes;

    /**
     * @ORM\ManyToMany(targetEntity="Rating\SubdivisionBundle\Entity\Cathedra", mappedBy="managers")
     */
    private $cathedras;

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
     * Get firstName
     *
     * @return string 
     */
    public function getFirstName()
    {
        return $this->firstName;
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
     * Get lastName
     *
     * @return string 
     */
    public function getLastName()
    {
        return $this->lastName;
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
     * Add jobs
     *
     * @param \Rating\SubdivisionBundle\Entity\Job $jobs
     * @return User
     */
    public function addJob(\Rating\SubdivisionBundle\Entity\Job $jobs)
    {
        $this->jobs[] = $jobs;

        return $this;
    }

    /**
     * Remove jobs
     *
     * @param \Rating\SubdivisionBundle\Entity\Job $jobs
     */
    public function removeJob(\Rating\SubdivisionBundle\Entity\Job $jobs)
    {
        $this->jobs->removeElement($jobs);
    }

    /**
     * Get jobs
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getJobs()
    {
        return $this->jobs;
    }

    /**
     * Set birthday
     *
     * @param \DateTime $birthday
     * @return User
     */
    public function setBirthday($birthday)
    {
        $this->birthday = $birthday;

        return $this;
    }

    /**
     * Get birthday
     *
     * @return \DateTime 
     */
    public function getBirthday()
    {
        return $this->birthday;
    }

    /**
     * Add institutes
     *
     * @param \Rating\SubdivisionBundle\Entity\Institute $institutes
     * @return User
     */
    public function addInstitute(\Rating\SubdivisionBundle\Entity\Institute $institutes)
    {
        $this->institutes[] = $institutes;

        return $this;
    }

    /**
     * Remove institutes
     *
     * @param \Rating\SubdivisionBundle\Entity\Institute $institutes
     */
    public function removeInstitute(\Rating\SubdivisionBundle\Entity\Institute $institutes)
    {
        $this->institutes->removeElement($institutes);
    }

    /**
     * Get institutes
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getInstitutes()
    {
        return $this->institutes;
    }

    /**
     * Add cathedras
     *
     * @param \Rating\SubdivisionBundle\Entity\Cathedra $cathedras
     * @return User
     */
    public function addCathedra(\Rating\SubdivisionBundle\Entity\Cathedra $cathedras)
    {
        $this->cathedras[] = $cathedras;

        return $this;
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

    public function __toString()
    {
        return $this->getLastName().' '.$this->getFirstName().' '.$this->getParentName();
    }

    public function getSalt()
    {
        return null;
    }

    public function getUsername()
    {
        return $this->getEmail();
    }

    public function getPassword()
    {
        return null;
    }
    public function eraseCredentials()
    {
        return null;
    }
    public function getRoles()
    {
        return $this->roles;
    }
    /** @see \Serializable::serialize() */
    public function serialize()
    {
        return serialize(array(
            $this->id,
            $this->email,
            $this->googleId,
            // see section on salt below
            // $this->salt,
        ));
    }

    /** @see \Serializable::unserialize() */
    public function unserialize($serialized)
    {
        list (
            $this->id,
            $this->email,
            $this->googleId,
            // see section on salt below
            // $this->salt
            ) = unserialize($serialized);
    }
    public function addRole($role)
    {
        $this->roles[] = $role;
        return $this;
    }


}
