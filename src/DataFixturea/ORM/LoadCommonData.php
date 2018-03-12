<?php
/**
 * Created by PhpStorm.
 * User: USER
 * Date: 07.03.2018
 * Time: 12:26
 */

namespace App\DataFixturea\ORM;


use App\Entity\User;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadCommonData implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $user = new User();

    }

}