<?php

declare(strict_types=1);

namespace App\DataTransformer\Api\User;

use ApiPlatform\Validator\ValidatorInterface;
use App\Dto\Api\User\UserInputPatchDto;
use App\Entity\User;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserInputPatchDataTransformer
{
    public function __construct(
        private ValidatorInterface $validator,
        private UserPasswordHasherInterface $hasher,
    ) {
    }

    public function transform(UserInputPatchDto $data, User $user): User
    {
        $this->validator->validate($data);

        $user->setFirstname($data->firstname);
        $user->setLastname($data->lastname);
        $user->setEmail($data->email);
        $user->setPhone($data->phone);

        return $user;
    }
}
