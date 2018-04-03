<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ItemsRepository")
 */
class Items
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;


    /**
     * @ORM\Column(type="string")
     */
    private $name;


    /**
     * @ORM\Column(type="integer")
     */
    private $price;


    /**
     * @ORM\ManyToMany(targetEntity="User", mappedBy="BoughtItems")
     */
    private $users;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\League", inversedBy="Items")
     *
     */
    private $targetLeague;





    public function getId()
    {
        return $this->id;
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
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param mixed $price
     */
    public function setPrice($price): void
    {
        $this->price = $price;
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
    public function     getTargetLeague()
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


}
