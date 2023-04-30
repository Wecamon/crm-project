<?php

declare(strict_types=1);

namespace App\Tests\Functional\Appointment;

use App\Tests\DataFixtures\Appointment\AppointmentsFixtures;
use App\Tests\DataFixtures\User\UsersFixtures;
use App\Tests\Functional\CustomApiTestCase;

class AppointmentTest extends CustomApiTestCase
{
    public function testGetAppointmentsByUser(): void
    {
        $this->loadFixtures(
            UsersFixtures::class,
            AppointmentsFixtures::class,
        );

        static::createClientWithCredentials(
            '7771',
            'cool',
        )->request(
            'GET',
            '/api/v1/users/1/appointments',
            [
                'headers' => [
                    'accept' => [
                        'Content-type' => 'application/json',
                    ],
                ],
            ]
        );

        $this->assertJsonContains([
            [
                'id' => 1,
                'title' => 'title1',
                'description' => 'description1',
                'schedule' => '2020-01-01T00:00:00+00:00',
                'price' => 1.0,
                'status' => 'created',
                'updatedAt' => null,
            ],
            [
                'id' => 2,
                'title' => 'title2',
                'description' => 'description2',
                'schedule' => '2020-01-01T00:00:00+00:00',
                'price' => 2.0,
                'status' => 'created',
                'updatedAt' => null,
            ],
        ]);
    }

    public function testGetAppointmentsMeByUser(): void
    {
        $this->loadFixtures(
            UsersFixtures::class,
            AppointmentsFixtures::class,
        );

        static::createClientWithCredentials(
            '7771',
            'cool',
        )->request(
            'GET',
            '/api/v1/users/me/appointments',
            [
                'headers' => [
                    'accept' => [
                        'Content-type' => 'application/json',
                    ],
                ],
            ]
        );

        $this->assertJsonContains([
            [
                'id' => 1,
                'title' => 'title1',
                'description' => 'description1',
                'schedule' => '2020-01-01T00:00:00+00:00',
                'price' => 1.0,
                'status' => 'created',
                'updatedAt' => null,
            ],
            [
                'id' => 2,
                'title' => 'title2',
                'description' => 'description2',
                'schedule' => '2020-01-01T00:00:00+00:00',
                'price' => 2.0,
                'status' => 'created',
                'updatedAt' => null,
            ],
        ]);
    }

    public function testGetForeignAppointmentsByUser(): void
    {
        $this->loadFixtures(
            UsersFixtures::class,
            AppointmentsFixtures::class,
        );

        $response = static::createClientWithCredentials(
            '7771',
            'cool',
        )->request(
            'GET',
            '/api/v1/users/2/appointments',
            [
                'headers' => [
                    'accept' => [
                        'Content-type' => 'application/json',
                    ],
                ],
            ]
        );

        $this->assertResponseStatusCodeSame(200);
        $this->assertCount(0, json_decode($response->getContent()));
    }
}
