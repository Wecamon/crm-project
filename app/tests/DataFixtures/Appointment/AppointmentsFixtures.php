<?php

declare(strict_types=1);

namespace App\Tests\DataFixtures\Appointment;

use App\Entity\Appointment;
use App\Entity\User;
use App\Tests\DataFixtures\User\UsersFixtures;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class AppointmentsFixtures extends Fixture implements DependentFixtureInterface
{
    private const USER_REFERENCES = [
        'user_1',
        'user_2',
        'user_3',
        'user_4',
    ];

    public function load(ObjectManager $manager): void
    {
        foreach (self::USER_REFERENCES as $userReference) {
            /** @var User $user */
            $user = $this->getReference($userReference);

            for ($i = 1; $i <= 2; $i++) {
                $appointment = new Appointment(
                    $user,
                    'title' . $i,
                    'description' . $i,
                    new DateTimeImmutable('2020-01-01'),
                    $i
                );

                $manager->persist($appointment);

                $this->addReference($userReference . '_appointment_' . $i, $appointment);
            }
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            UsersFixtures::class,
        ];
    }
}
