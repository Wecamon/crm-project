<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < 20; $i++) {
            $user = new User(
                'email'.$i.'@gmail.com',
                $i.'-'.$i.'-' .$i,
                'Firstname '.$i,
                'Lastname '.$i,
                ['ROLE_USER']
            );
            $manager->persist($user);
        }

        $manager->flush();
    }
}
