<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
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
     * @return mixed
     */
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


    // add your own fields
}
