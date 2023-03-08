<?php

namespace App\Dto;

use Symfony\Component\Serializer\Annotation\Groups;

class PatchUserInput
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
