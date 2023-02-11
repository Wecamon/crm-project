<?php

namespace App\Dto;

use Symfony\Component\Serializer\Annotation\Groups;

class PatchUserInput
{
    #[Groups(["User:write"])]
    public ?string $firstname;

    #[Groups(["User:write"])]
    public ?string $lastname;

    #[Groups(["User:write"])]
    public ?string $email;

    #[Groups(["User:write"])]
    public ?string $phone;
}
