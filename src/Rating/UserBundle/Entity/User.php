<?php

namespace Rating\UserBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping\AttributeOverrides;
use Doctrine\ORM\Mapping\AttributeOverride;

/**
 * @ORM\Entity
 * @ORM\Table(name="user")
 *
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    public function __construct()
    {
        parent::__construct();
        $this->jobs = new ArrayCollection();
    }
    /**
     * @ORM\Column(type="string", length=255)
     *
     * @Assert\NotBlank(message="Будь ласка, введіть Ваше ім'я.", groups={"RatingRegistration", "RatingProfile"})
     * @Assert\Length(
     *     min=3,
     *     max="255",
     *     minMessage="Ім'я занадто коротке.",
     *     maxMessage="Ім'я занадто довге.",
     *     groups={"Registration", "Profile", "RatingRegistration", "RatingProfile"}
     * )
     */
    protected $firstName;
    /**
     * @ORM\Column(type="string", length=255)
     *
     * @Assert\NotBlank(message="Будь ласка, введіть Ваше прізвище.", groups={"RatingRegistration", "RatingProfile"})
     * @Assert\Length(
     *     min=3,
     *     max="255",
     *     minMessage="Прізвище занадто коротке.",
     *     maxMessage="Прізвище занадто довге.",
     *     groups={"Registration", "Profile", "RatingRegistration", "RatingProfile"}
     * )
     */
    protected $lastName;
    /**
     * @ORM\Column(type="string", length=255)
     *
     * @Assert\NotBlank(message="Будь ласка, введіть Ваше по-батькові.", groups={"RatingRegistration", "RatingProfile"})
     * @Assert\Length(
     *     min=3,
     *     max="255",
     *     minMessage="Мінімальна кількість символів - 3",
     *     maxMessage="Максимальна кількість символів - 255.",
     *     groups={"Registration", "Profile", "RatingRegistration", "RatingProfile"}
     * )
     */
    protected $parentName;

    /**
     * @ORM\Column(type="datetime", length=255, nullable=true)
    */
    protected $birthday;

    /**
     * @ORM\OneToMany(targetEntity="Rating\SubdivisionBundle\Entity\Job", mappedBy="user")
     */
    protected $jobs;

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
    public function setEmail($email){
        $email = is_null($email) ? '' : $email;
        parent::setEmail($email);
        $this->setUsername($email);
    }

    public function setEmailCanonical($emailCanonical){
        $this->emailCanonical = $emailCanonical;
        $this->usernameCanonical = $emailCanonical;
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
}
