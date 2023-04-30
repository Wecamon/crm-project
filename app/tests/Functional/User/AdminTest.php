<?php

declare(strict_types=1);

namespace App\Tests\Functional\User;

use App\Tests\DataFixtures\User\UsersFixtures;
use App\Tests\Functional\CustomApiTestCase;

class AdminTest extends CustomApiTestCase
{
    public function testGetUserById(): void
    {
        $this->loadFixtures(UsersFixtures::class);

        static::createClientWithCredentials(
            'admin',
            'cool'
        )->request('GET', '/api/v1/users/2', [
            'headers' => [
                'accept' => [
                    'Content-type' => 'application/json',
                ],
            ],
        ]);

        $this->assertResponseStatusCodeSame(200);
        $this->assertJsonContains([
            'firstname' => 'firstname2',
            'lastname' => 'lastname2',
            'phone' => '7772',
            'email' => 'user2@gmail.com',
        ]);
    }

    public function testGetUsersRequest(): void
    {
        $this->loadFixtures(UsersFixtures::class);

        $response = static::createClientWithCredentials(
            'admin',
            'cool'
        )->request('GET', '/api/v1/users', [
            'headers' => [
                'accept' => [
                    'Content-type' => 'application/json',
                ],
            ],
        ]);

        $this->assertResponseStatusCodeSame(200);
        $this->assertCount(5, json_decode($response->getContent(), true));
    }

    public function testPatchUserRequest(): void
    {
        $this->loadFixtures(UsersFixtures::class);

        static::createClientWithCredentials(
            'admin',
            'cool',
        )->request(
            'PATCH',
            '/api/v1/users/2',
            [
                'headers' => [
                    'accept' => [
                        'Content-type' => 'application/json',
                    ],
                ],
                'json' => [
                    'lastname' => 'new lastname',
                ],
            ]
        );

        $this->assertResponseStatusCodeSame(200);
        $this->assertJsonContains([
            'firstname' => 'firstname2',
            'lastname' => 'new lastname',
        ]);
    }
}
