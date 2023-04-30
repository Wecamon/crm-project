<?php

declare(strict_types=1);

namespace App\DataTransformer\Api\User;

use ApiPlatform\Validator\ValidatorInterface;
use App\Dto\Api\User\UserInputPostDto;
use App\Entity\User;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserInputPostDataTransformer
{
    public function __construct(
        private ValidatorInterface $validator,
        private UserPasswordHasherInterface $hasher
    ) {
    }

    public function transform(UserInputPostDto $data): User
    {
        $this->validator->validate($data);

        return new User(
            $data->email,
            $data->phone,
            $data->firstname,
            $data->lastname,
            $data->password,
            $this->hasher
        );
    }
}
