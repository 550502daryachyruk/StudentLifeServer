<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\LeagueRepository")
 */
class League
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;


    /**
     * @ORM\OneToMany(targetEntity="League", mappedBy="parentLeague")
     */
    private $childrenLeagues;

    /**
     * @ORM\ManyToOne(targetEntity="League", inversedBy="childrenLeagues")
     */
    private $parentLeague;


    /**
     * @ORM\ManyToMany(targetEntity="Product", mappedBy="categories")
     */
    private $admins;
    /**
     * @ORM\ManyToMany(targetEntity="Product", mappedBy="categories")
     */
    private $users;

    private $events;





    /**
     * @return integer
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getChildrenLeagues()
    {
        return $this->childrenLeagues;
    }

    /**
     * @param mixed $childrenLeagues
     */
    public function setChildrenLeagues($childrenLeagues): void
    {
        $this->childrenLeagues = $childrenLeagues;
    }

    /**
     * @return mixed
     */
    public function getParentLeague()
    {
        return $this->parentLeague;
    }

    /**
     * @param mixed $parentLeague
     */
    public function setParentLeague($parentLeague): void
    {
        $this->parentLeague = $parentLeague;
    }

    /**
     * @return mixed
     */
    public function getAdmins()
    {
        return $this->admins;
    }

    /**
     * @param mixed $admins
     */
    public function setAdmins($admins): void
    {
        $this->admins = $admins;
    }

    /**
     * @return mixed
     */
    public function getUsers()
    {
        return $this->users;
    }

    /**
     * @param mixed $users
     */
    public function setUsers($users): void
    {
        $this->users = $users;
    }

}
