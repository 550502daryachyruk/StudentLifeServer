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

    private $leaguesWhereAdmin;
    private $leaguesWhereUser;

    private $alreadyPlayedEvent;
    private $willBePlayedEvent;


    // add your own fields
}
