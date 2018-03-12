<?php

namespace App\Entity;

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
     */
    private $leaguesWhereAdmin;
    /**
     * @ORM\ManyToMany(targetEntity="League", inversedBy="users")
     */
    private $leaguesWhereUser;

    private $alreadyPlayedEvent;

    private $willBePlayedEvent;
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
     *
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


}
