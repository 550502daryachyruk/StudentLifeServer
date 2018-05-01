<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinColumn;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EventRepository")
 */
class Event
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\League", inversedBy="events")
     *
     */
    private $targetLeague;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\User", inversedBy="alreadyPlayedEvent")
     *
     */
    private $targetUsers;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getTargetLeague()
    {
        return $this->targetLeague;
    }

    /**
     * @param mixed $targetLeague
     */
    public function setTargetLeague($targetLeague): void
    {
        $this->targetLeague = $targetLeague;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description): void
    {
        $this->description = $description;
    }

    /**
     * @return mixed
     */
    public function getTargetUsers()
    {
        return $this->targetUsers;
    }

    /**
     * @param mixed $targetUsers
     */
    public function setTargetUsers($targetUsers): void
    {
        $this->targetUsers = $targetUsers;
    }
    public function __construct() {
        $this->targetUsers = new \Doctrine\Common\Collections\ArrayCollection();
    }
    // add your own fields
}
