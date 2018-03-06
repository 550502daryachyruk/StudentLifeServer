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

    private $childrenLeagues;
    private $parentLeague;

    private $admins;
    private $users;

    private $events;

    /**
     * @return integer
     */
    public function getId(): int
    {
        return $this->id;
    }

    // add your own fields
}
