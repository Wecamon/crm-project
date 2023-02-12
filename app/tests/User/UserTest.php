<?php

namespace App\Tests;

use App\DataFixtures\UserFixtures;
use App\Test\CustomApiTestCase;

class UserTest extends CustomApiTestCase
{
    public function testPostUserRequest(): void
    {
        $this->loadFixtures(UserFixtures::class);
        $client = self::createClient();
        $client->request('POST', '/api/v1/users', [
            'headers' => [
                'accept' => [
                    'Content-Type' => 'application/json'
                ]],
            'json' => [
                'firstname' => 'helpme',
                'phone' => '9023239',
            ]
        ]);
        $this->assertResponseStatusCodeSame(201);
    }

    public function testGetUserRequest(): void
    {
        $this->loadFixtures(UserFixtures::class);
        dd('stop');
        $client = self::createClient();
        $response = $client->request('GET', '/api/v1/users/1', [
            'headers' => [
                'accept' => [
                    'Content-Type' => 'application/json'
                ]]
        ]);
        $this->assertJson($response->getContent());
        // $this->assertJsonContains([
        //     'firstname' => 'Firstname 1'
        // ]);
    }

    public function testGetUsersRequest(): void
    {
        $this->loadFixtures(UserFixtures::class);
        $client = self::createClient();
        $response = $client->request('GET', '/api/v1/users', [
            'headers' => [
                'accept' => [
                    'Content-type' => 'application/json'
                ]],
            'json' => []
        ]);
        $this->assertCount(20, json_decode($response->getContent(), true));
    }

    public function testPatchUserRequest(): void
    {
        $this->loadFixtures(UserFixtures::class);
        $client = self::createClient();
        $client->request('PATCH', '/api/v1/users/1', [
            'headers' => [
                'accept' => [
                    'Content-type' => 'application/json'
                ]],
            'json' => [
                'firstname' => 'new firstname',
                'lastname' => 'new lastname'
            ],
        ]);
        $this->assertResponseStatusCodeSame(200);
    }
}
