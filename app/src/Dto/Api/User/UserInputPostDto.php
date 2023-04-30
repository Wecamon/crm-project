<?php

declare(strict_types=1);

namespace App\Dto\Api\User;

use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

class UserInputPostDto
{
    #[Groups(['User:write'])]
    #[Assert\NotBlank()]
    public string $firstname;

    #[Groups(['User:write'])]
    #[Assert\NotBlank(allowNull: true)]
    public ?string $lastname = null;

    #[Groups(['User:write'])]
    #[Assert\NotBlank(allowNull: true)]
    public ?string $email = null;

    #[Groups(['User:write'])]
    #[Assert\NotBlank()]
    public string $phone;

    #[Groups(['User:write'])]
    #[Assert\NotBlank()]
    public string $password;
}
