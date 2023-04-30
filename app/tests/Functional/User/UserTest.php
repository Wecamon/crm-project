<?php

namespace App\Tests\Functional\User;

use App\Tests\DataFixtures\User\UsersFixtures;
use App\Tests\Functional\CustomApiTestCase;

class UserTest extends CustomApiTestCase
{
    public function setUp(): void
    {
        parent::setUp();
    }

    public function testPostUserRequest(): void
    {
        $this->loadFixtures(UsersFixtures::class);

        static::createClient()->request(
            'POST',
            '/api/v1/register',
            [
                'headers' => [
                    'accept' => [
                        'Content-Type' => 'application/json',
                    ],
                ],
                'json' => [
                    'firstname' => 'test_user',
                    'phone' => '9023239',
                    'password' => 'cool',
                ],
            ]
        );

        $this->assertResponseStatusCodeSame(201);
        $this->assertJsonContains([
            'firstname' => 'test_user',
            'phone' => '9023239',
            'lastname' => null,
            'email' => null,
        ]);
    }

    public function testGetUsersRequest(): void
    {
        $this->loadFixtures(UsersFixtures::class);

        $response = static::createClientWithCredentials(
            '7771',
            'cool'
        )->request('GET', '/api/v1/users', [
            'headers' => [
                'accept' => [
                    'Content-type' => 'application/json',
                ],
            ],
        ]);

        $this->assertResponseStatusCodeSame(200);
        $this->assertCount(1, json_decode($response->getContent(), true));
    }

    public function testGetMe(): void
    {
        $this->loadFixtures(UsersFixtures::class);

        static::createClientWithCredentials(
            '7771',
            'cool'
        )->request('GET', '/api/v1/users/me', [
            'headers' => [
                'accept' => [
                    'Content-type' => 'application/json',
                ],
            ],
        ]);

        $this->assertResponseStatusCodeSame(200);
        $this->assertJsonContains([
            'firstname' => 'firstname1',
            'lastname' => 'lastname1',
            'phone' => '7771',
            'email' => 'user1@gmail.com',
        ]);
    }

    public function testGetUserById(): void
    {
        $this->loadFixtures(UsersFixtures::class);

        static::createClientWithCredentials(
            '7771',
            'cool'
        )->request('GET', '/api/v1/users/1', [
            'headers' => [
                'accept' => [
                    'Content-type' => 'application/json',
                ],
            ],
        ]);

        $this->assertResponseStatusCodeSame(200);
        $this->assertJsonContains([
            'firstname' => 'firstname1',
            'lastname' => 'lastname1',
            'phone' => '7771',
            'email' => 'user1@gmail.com',
        ]);
    }

    public function testGetAnotherUserById(): void
    {
        $this->loadFixtures(UsersFixtures::class);

        static::createClientWithCredentials(
            '7771',
            'cool'
        )->request('GET', '/api/v1/users/2', [
            'headers' => [
                'accept' => [
                    'Content-type' => 'application/json',
                ],
            ],
        ]);

        $this->assertResponseStatusCodeSame(404);
        $this->assertJsonContains([
            'title' => 'An error occurred',
            'detail' => 'Not Found',
        ]);
    }

    public function testPatchUserMeRequest(): void
    {
        $this->loadFixtures(UsersFixtures::class);

        static::createClientWithCredentials(
            '7771',
            'cool',
        )->request(
            'PATCH',
            '/api/v1/users/me',
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
            'id' => 1,
            'firstname' => 'firstname1',
            'lastname' => 'new lastname',
        ]);
    }

    public function testPatchUserMeByIdRequest(): void
    {
        $this->loadFixtures(UsersFixtures::class);

        static::createClientWithCredentials(
            '7771',
            'cool',
        )->request(
            'PATCH',
            '/api/v1/users/1',
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
            'id' => 1,
            'firstname' => 'firstname1',
            'lastname' => 'new lastname',
        ]);
    }

    public function testPatchAnotherUserRequest(): void
    {
        $this->loadFixtures(UsersFixtures::class);

        static::createClientWithCredentials(
            '7771',
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

        $this->assertResponseStatusCodeSame(404);
        $this->assertJsonContains([
            'title' => 'An error occurred',
            'detail' => 'Not Found'
        ]);
    }
}
