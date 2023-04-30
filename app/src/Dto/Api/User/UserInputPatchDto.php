<?php

declare(strict_types=1);

namespace App\Dto\Api\User;

use Symfony\Component\Serializer\Annotation\Groups;

class UserInputPatchDto
{
    #[Groups(['User:write'])]
    public ?string $firstname = null;

    #[Groups(['User:write'])]
    public ?string $lastname = null;

    #[Groups(['User:write'])]
    public ?string $email = null;

    #[Groups(['User:write'])]
    public ?string $phone = null;

    #[Groups(['User:write'])]
    public ?string $password = null;
}
