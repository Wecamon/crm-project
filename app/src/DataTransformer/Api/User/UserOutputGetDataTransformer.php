<?php

declare(strict_types=1);

namespace App\DataTransformer\Api\User;

use App\Dto\Api\User\UserOutputDto;
use App\Entity\User;

class UserOutputGetDataTransformer
{
    public function transform(User $user): UserOutputDto
    {
        return new UserOutputDto(
            $user->getId(),
            $user->getFirstname(),
            $user->getLastname(),
            $user->getEmail(),
            $user->getPhone(),
            $user->getCreatedAt()
        );
    }
}
