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
     * @ORM\Column(type="string")
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="League", mappedBy="parentLeague")
     */
    private $childrenLeagues;

    /**
     * @ORM\ManyToOne(targetEntity="League", inversedBy="childrenLeagues")
     */
    private $parentLeague;


    /**
     *
     * @ORM\ManyToMany(targetEntity="User", mappedBy="leaguesWhereAdmin")
     * @ORM\JoinTable(name="user_league1")
     */
    private $admins;
    /**
     * @ORM\ManyToMany(targetEntity="User", mappedBy="leaguesWhereUser")
     */
    private $users;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Event", mappedBy="targetLeague")
     */
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

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name): void
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getEvents()
    {
        return $this->events;
    }

    /**
     * @param mixed $events
     */
    public function setEvents($events): void
    {
        $this->events = $events;
    }
    public function __construct()
    {
        $this->events = new ArrayCollection();
    }

}
