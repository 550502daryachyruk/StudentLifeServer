<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\NotificationRepository")
 */
class Notification
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;
    /**
    * @ORM\Column(type="integer")
    */
    private $userid;

    /**
     * @ORM\Column(type="integer")
     */
    private $eventid;

    /**
     * @ORM\Column(type="date")
     */
    private $dataOfCreate;


    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getEventid()
    {
        return $this->eventid;
    }

    /**
     * @param mixed $eventid
     */
    public function setEventid($eventid): void
    {
        $this->eventid = $eventid;
    }

    /**
     * @return mixed
     */
    public function getUserid()
    {
        return $this->userid;
    }

    /**
     * @param mixed $userid
     */
    public function setUserid($userid): void
    {
        $this->userid = $userid;
    }

    /**
     * @return mixed
     */
    public function getDataOfCreate()
    {
        return $this->dataOfCreate;
    }

    /**
     * @param mixed $dataOfCreate
     */
    public function setDataOfCreate($dataOfCreate): void
    {
        $this->dataOfCreate = $dataOfCreate;
    }
}
