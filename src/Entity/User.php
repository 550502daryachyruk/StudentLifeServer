<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @ORM\HasLifecycleCallbacks()
 * @UniqueEntity("username",message="username_already_registered")
 * @UniqueEntity("email",message="email_already_registered")
 */
class User
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToMany(targetEntity="League", inversedBy="admins")
     * @ORM\JoinTable(name="user_league1")
     */
    private $leaguesWhereAdmin;
    /**
     * @ORM\ManyToMany(targetEntity="League", inversedBy="users")
     */
    private $leaguesWhereUser;


    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Items", inversedBy="users")
     */
    private $BoughtItems;


    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Event", mappedBy="targetUsers")
     */
    private $alreadyPlayedEvent;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Event", mappedBy="userLiked")
     * @ORM\JoinTable(name="user_event_like")
     */
    private $eventsLiked;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Currency", mappedBy="users")
     */
    private $currencys;


    /**
     * @ORM\Column(type="string", length=16)
     * @Assert\NotBlank( message="firstname_error")
     */
    private $firstname;

    /**
     * @ORM\Column(type="string", length=16)
     * @Assert\NotBlank( message="lastname_error")
     */
    private $lastname;

    /**
     * @ORM\Column(type="string", length=16, unique=true)
     * @Assert\NotBlank( message="username_error")
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=32, unique=true)
     * @Assert\NotBlank(message="email_error")
     * @Assert\Email()
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=32)
     * @Assert\NotBlank(message="password_error")
     */
    private $password;

    /**
     * @ORM\Column(type="boolean")
     * @Assert\NotBlank(message="sex_error")
     */
    private $sex;    //if true = male

    /**
     * @ORM\Column(type="date")
     * @Assert\Date()
     */
    private $birthdayDate;

    /**
     * @ORM\Column(type="date")
     */
    private $registerDate;

    /**
     * @ORM\Column(type="string")
     * @Assert\Image()
     */
    private $avatarImage;



    /**
     * @return mixed
     */
    public function getAvatarImage()
    {
        return $this->avatarImage;
    }

    /**
     * @param mixed $avatarImage
     */
    public function setAvatarImage($avatarImage): void
    {
        $this->avatarImage = $avatarImage;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param mixed $username
     */
    public function setUsername($username): void
    {
        $this->username = $username;
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
    public function setEmail($email): void
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password): void
    {
        $this->password = $password;
    }

    /**
     * @return mixed
     */
    public function getSex()
    {
        return $this->sex;
    }

    /**
     * @param mixed $sex
     */
    public function setSex($sex): void
    {
        $this->sex = $sex;
    }

    /**
     * @return mixed
     */
    public function getBirthdayDate()
    {
        return $this->birthdayDate;
    }

    /**
     * @param mixed $birthdayDate
     */
    public function setBirthdayDate($birthdayDate): void
    {
        $this->birthdayDate = $birthdayDate;
    }

    public function getLeaguesWhereAdmin()
    {
        return $this->leaguesWhereAdmin;
    }

    /**
     * @param mixed $leaguesWhereAdmin
     */
    public function setLeaguesWhereAdmin($leaguesWhereAdmin): void
    {
        $this->leaguesWhereAdmin = $leaguesWhereAdmin;
    }

    /**
     * @param mixed $leaguesWhereAdmin
     */
    public function addLeaguesWhereAdmin($leaguesWhereAdmin): void
    {
        $this->leaguesWhereAdmin[] = $leaguesWhereAdmin;
    }

    /**
     * @return mixed
     */
    public function getLeaguesWhereUser()
    {
        return $this->leaguesWhereUser;
    }

    /**
     * @param mixed $leaguesWhereUser
     */
    public function setLeaguesWhereUser($leaguesWhereUser): void
    {
        $this->leaguesWhereUser = $leaguesWhereUser;
    }
    public function addLeaguesWhereUser($leaguesWhereUser): void
    {
        $this->leaguesWhereUser[] = $leaguesWhereUser;
    }
    public function removeLeaguesWhereUser($leaguesWhereUser): void
    {
        $this->leaguesWhereUser->removeElement($leaguesWhereUser);
    }

    public function getRegisterDate()
    {
        return $this->registerDate;
    }

    /**
     * @ORM\PrePersist
     */
    public function setRegisterDate(): void
    {
        $this->registerDate = new \DateTime();
    }

    /**
     * @return mixed
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * @param mixed $firstname
     */
    public function setFirstname($firstname): void
    {
        $this->firstname = $firstname;
    }

    /**
     * @return mixed
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * @param mixed $lastname
     */
    public function setLastname($lastname): void
    {
        $this->lastname = $lastname;
    }

    /**
     * @return mixed
     */
    public function getAlreadyPlayedEvent()
    {
        return $this->alreadyPlayedEvent;
    }

    /**
     * @param mixed $alreadyPlayedEvent
     */
    public function setAlreadyPlayedEvent($alreadyPlayedEvent): void
    {
        $this->alreadyPlayedEvent = $alreadyPlayedEvent;
    }
    public function __construct() {
        $this->alreadyPlayedEvent = new \Doctrine\Common\Collections\ArrayCollection();
        $this->leaguesWhereUser= new \Doctrine\Common\Collections\ArrayCollection();
        $this->leaguesWhereAdmin= new \Doctrine\Common\Collections\ArrayCollection();
        $this->BoughtItems= new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getBoughtItems()
    {
        return $this->BoughtItems;
    }

    /**
     * @param mixed $BoughtItems
     */
    public function setBoughtItems($BoughtItems): void
    {
        $this->BoughtItems = $BoughtItems;
    }

    /**
     * @param mixed $BoughtItems
     */
    public function addBoughtItems($BoughtItem){
        $this->BoughtItems[] = $BoughtItem;
    }


    /**
     * @return mixed
     */
    public function getCurrencys()
    {
        return $this->currencys;
    }

    /**
     * @return mixed
     */
    public function getCurrencysById($leagueId)
    {
        /** @var  $cur Currency*/
        foreach ($this->currencys as $cur){
            if($cur->getLeaguesId() == $leagueId) return $cur;
        }
    }



    /**
     * @param mixed $currencys
     */
    public function setCurrencys($currencys): void
    {
        $this->currencys = $currencys;
    }

    /**
     * @return mixed
     */
    public function getEventsLiked()
    {
        return $this->eventsLiked;
    }

    /**
     * @param mixed $eventsLiked
     */
    public function setEventsLiked($eventsLiked): void
    {
        $this->eventsLiked = $eventsLiked;
    }

}
