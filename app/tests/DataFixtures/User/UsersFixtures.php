<?php

declare(strict_types=1);

namespace App\Tests\DataFixtures\User;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Mockery;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UsersFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $hasher = Mockery::mock(UserPasswordHasherInterface::class);
        $hasher
            ->shouldReceive('hashPassword')
            ->andReturn('$2y$13$YzSg5mt5FI4qT0DFtYaLreTLfReNJWkQbg.HFxvKlxd3Zcwexqw4e');
        
        for ($i = 1; $i <= 4; $i++) {
            $user = new User(
                'user' . $i . '@gmail.com',
                '777' . $i,
                'firstname' . $i,
                'lastname' . $i,
                'cool',
                $hasher
            );

            $manager->persist($user);

            $this->addReference('user_' . $i, $user);
        }

        $admin = new User(
            'admin@gmail.com',
            'admin',
            'admin',
            'admin',
            'cool',
            $hasher
        );
        $admin->addRole('ROLE_ADMIN');

        $manager->persist($admin);

        $this->addReference('admin', $admin);

        $manager->flush();
    }
}
