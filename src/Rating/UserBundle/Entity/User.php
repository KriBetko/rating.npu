<?php

namespace Rating\UserBundle\Entity;

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
     *
     *
     */
    protected $id;

    public function __construct()
    {
        parent::__construct();
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
     *     groups={"Registration", "Profile"}
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
     *     groups={"Registration", "Profile"}
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
     *     groups={"Registration", "Profile"}
     * )
     */
    protected $parentName;
    /**
     * @ORM\ManyToOne(targetEntity="Rating\SubdivisionBundle\Entity\Institute", inversedBy="users")
     * @ORM\JoinColumn(name="institute_id", referencedColumnName="id")
     */
    protected $institute;
    /**
     * @ORM\ManyToOne(targetEntity="Rating\SubdivisionBundle\Entity\Cathedra", inversedBy="users")
     * @ORM\JoinColumn(name="cathedra_id", referencedColumnName="id")
     */
    protected $cathedra;

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
     * Set institute
     *
     * @param \Rating\SubdivisionBundle\Entity\Institute $institute
     * @return User
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
     * Set cathedra
     *
     * @param \Rating\SubdivisionBundle\Entity\Cathedra $cathedra
     * @return User
     */
    public function setCathedra(\Rating\SubdivisionBundle\Entity\Cathedra $cathedra = null)
    {
        $this->cathedra = $cathedra;

        return $this;
    }

    /**
     * Get cathedra
     *
     * @return \Rating\SubdivisionBundle\Entity\Cathedra 
     */
    public function getCathedra()
    {
        return $this->cathedra;
    }
}
