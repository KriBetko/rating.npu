<?php
namespace Rating\SubdivisionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Rating\UserBundle\Entity\User;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="Rating\SubdivisionBundle\Repository\JobRepository")
 * @ORM\Table(name="jobs")
 */
class Job
{
    const FORM_DAILY        = 1;
    const FORM_EXTRAMURAL   = 2;


    // TODO refactor this
    protected $formList =
        [
            self::FORM_DAILY        => 'Денна',
            self::FORM_EXTRAMURAL   => 'Заочна'

        ];

    public static $fList =
        [
            self::FORM_DAILY        => 'Денна',
            self::FORM_EXTRAMURAL   => 'Заочна'

        ];

    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="Rating\UserBundle\Entity\User", inversedBy="jobs")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    protected $user;

    /**
     * @ORM\ManyToOne(targetEntity="Rating\SubdivisionBundle\Entity\Position")
     * @ORM\JoinColumn(name="position_id", referencedColumnName="id")
     * @Assert\NotBlank(message="Будь ласка, оберіть Вашу посаду.", groups={"addJob"})
     */
    protected $position;

    /**
     * @ORM\ManyToOne(targetEntity="Rating\SubdivisionBundle\Entity\Cathedra")
     * @ORM\JoinColumn(name="cathedra_id", referencedColumnName="id")
     * @Assert\NotBlank(message="Будь ласка, оберіть кафедру.", groups={"addJob"})
     */
    protected $cathedra;

    /**
     * @ORM\ManyToOne(targetEntity="Rating\SubdivisionBundle\Entity\Institute")
     * @ORM\JoinColumn(name="institute_id", referencedColumnName="id")
     * @Assert\NotBlank(message="Будь ласка, оберіть інститут.", groups={"addJob"})
     */
    protected $institute;

    /**
     * @ORM\Column(type="decimal", scale=2, nullable=true)
     * @Assert\Range(
     *      min = 0.00,
     *      max = 1.00,
     *      minMessage = "Значення має бути від 0 до 1",
     *      maxMessage = "Значення має бути від 0 до 1", groups={"addJob"}
     * )
     * @Assert\NotBlank(message="Будь ласка, вкажіть ставку (від 0.00 до 1.00).", groups={"addJob"})
     */
    protected $bet;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    protected $additional;

    /**
     * @ORM\Column(name="group_name", type="string", length=64, nullable=true)
     * @Assert\NotBlank(message="Будь ласка, вкажіть навчальну группу", groups={"education"})
     */
    protected $group;
    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Assert\NotBlank(message="Будь ласка, вкажіть форму навчання", groups={"education"})
     */
    protected $formEducation;
    /**
     * @ORM\Column(type="date", length=64, nullable=true)
     * @Assert\NotBlank(message="Будь ласка, оберіть рік вступу", groups={"education"})
     */
    protected $entryYear;
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\NotBlank(message="Будь ласка, вкажіть спеціальність", groups={"education"})
     */
    protected $specialization;

    /**
     * @return mixed
     */
    public function getEntryYear()
    {
        return $this->entryYear;
    }

    /**
     * @param mixed $entryYear
     */
    public function setEntryYear($entryYear)
    {
        $this->entryYear = $entryYear;
    }

    /**
     * @return mixed
     */
    public function getFormEducation()
    {
        return $this->formEducation;
    }

    /**
     * @param mixed $formEducation
     */
    public function setFormEducation($formEducation)
    {
        $this->formEducation = $formEducation;
    }

    /**
     * @return array
     */
    public function getFormList()
    {
        return $this->formList;
    }

    /**
     * @param array $formList
     */
    public function setFormList($formList)
    {
        $this->formList = $formList;
    }

    /**
     * @return mixed
     */
    public function getGroup()
    {
        return $this->group;
    }

    /**
     * @param mixed $group
     */
    public function setGroup($group)
    {
        $this->group = $group;
    }

    /**
     * @return mixed
     */
    public function getSpecialization()
    {
        return $this->specialization;
    }

    /**
     * @param mixed $specialization
     */
    public function setSpecialization($specialization)
    {
        $this->specialization = $specialization;
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
     * Set bet
     *
     * @param string $bet
     * @return Job
     */
    public function setBet($bet)
    {
        $this->bet = $bet;

        return $this;
    }

    /**
     * Get bet
     *
     * @return string 
     */
    public function getBet()
    {
        return $this->bet;
    }

    /**
     * Set additional
     *
     * @param boolean $additional
     * @return Job
     */
    public function setAdditional($additional)
    {
        $this->additional = $additional;

        return $this;
    }

    /**
     * Get additional
     *
     * @return boolean 
     */
    public function getAdditional()
    {
        return $this->additional;
    }

    /**
     * Set user
     *
     * @param User $user
     * @return Job
     */
    public function setUser(User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set position
     *
     * @param Position $position
     * @return Job
     */
    public function setPosition(Position $position = null)
    {
        $this->position = $position;

        return $this;
    }

    /**
     * Get position
     *
     * @return Position
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * Set cathedra
     *
     * @param Cathedra $cathedra
     * @return Job
     */
    public function setCathedra(Cathedra $cathedra = null)
    {
        $this->cathedra = $cathedra;

        return $this;
    }

    /**
     * Get cathedra
     *
     * @return Cathedra
     */
    public function getCathedra()
    {
        return $this->cathedra;
    }

    /**
     * Set institute
     *
     * @param Institute $institute
     * @return Job
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
}
