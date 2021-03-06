<?php
namespace SubdivisionBundle\Entity;

use Doctrine\DBAL\Types\DecimalType;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use UserBundle\Entity\User;

/**
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="SubdivisionBundle\Repository\JobRepository")
 * @ORM\Table(name="jobs")
 */
class Job
{
    const FORM_DAILY = 1;
    const FORM_EXTRAMURAL = 2;

    // TODO refactor this
    public static $fList =
        [
            self::FORM_DAILY => 'Денна',
            self::FORM_EXTRAMURAL => 'Заочна'

        ];
    protected $formList =
        [
            self::FORM_DAILY => 'Денна',
            self::FORM_EXTRAMURAL => 'Заочна'

        ];
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\User", inversedBy="jobs")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    protected $user;

    /**
     * @ORM\ManyToOne(targetEntity="SubdivisionBundle\Entity\Position")
     * @ORM\JoinColumn(name="position_id", referencedColumnName="id")
     * @Assert\NotBlank(message="Будь ласка, оберіть Вашу посаду.", groups={"addJob"})
     */
    protected $position;

    /**
     * @ORM\ManyToOne(targetEntity="SubdivisionBundle\Entity\Cathedra")
     * @ORM\JoinColumn(name="cathedra_id", referencedColumnName="id")
     * @Assert\NotBlank(message="Будь ласка, оберіть кафедру.", groups={"addJob"})
     */
    protected $cathedra;

    /**
     * @ORM\ManyToOne(targetEntity="SubdivisionBundle\Entity\Institute")
     * @ORM\JoinColumn(name="institute_id", referencedColumnName="id")
     * @Assert\NotBlank(message="Будь ласка, оберіть факультет.", groups={"addJob"})
     */
    protected $institute;

    /**
     * @ORM\Column(type="decimal", scale=2, nullable=true)
     * @Assert\Range(
     *      min = 0.00,
     *      max = 1.00,
     *      minMessage = "Значення має бути від 0 до 1",
     *      maxMessage = "Значення має бути від 0 до 1", groups={"addJob"},
     *     invalidMessage="Значення має бути від 0 до 1"
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
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Year"));
     * @ORM\JoinColumn(name="year_id", referencedColumnName="id")
     * @Assert\NotBlank(message="Будь ласка, оберіть рік вступу", groups={"education"})
     */
    protected $year;
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @ORM\JoinColumn(name="yaer_id", referencedColumnName="id")
     * @Assert\NotBlank(message="Будь ласка, вкажіть спеціальність", groups={"education"})
     */
    protected $specialization;

    /** @ORM\Column(type="integer") */
    private $rating = 0;

    /**
     * @return mixed
     */
    public function getYear()
    {
        return $this->year;
    }

    public function setYear($year)
    {
        $this->year = $year;
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
     * Get bet
     *
     * @return DecimalType
     */
    public function getBet()
    {
        return $this->bet;
    }

    /**
     * Set bet
     *
     * @param string $bet
     */
    public function setBet($bet)
    {
        $this->bet = $bet;
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
     * Get user
     *
     * @return User
     */
    public function getUser()
    {
        return $this->user;
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
     * Get position
     *
     * @return Position
     */
    public function getPosition()
    {
        return $this->position;
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
     * Get cathedra
     *
     * @return Cathedra
     */
    public function getCathedra()
    {
        return $this->cathedra;
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
     * @return Job
     */
    public function setInstitute(Institute $institute = null)
    {
        $this->institute = $institute;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getRating()
    {
        return $this->rating;
    }

    /**
     * @param mixed $rating
     */
    public function setRating($rating)
    {
        $this->rating = $rating;
    }
}
