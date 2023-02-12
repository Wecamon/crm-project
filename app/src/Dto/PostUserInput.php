<?php

namespace App\Dto;

use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

class PostUserInput
{
    #[Groups(["User:write"])]
    #[Assert\NotBlank()]
    public string $firstname;

    #[Groups(["User:write"])]
    #[Assert\NotBlank(allowNull: true)]
    public ?string $lastname = null;

    #[Groups(["User:write"])]
    #[Assert\NotBlank(allowNull: true)]
    public ?string $email = null;

    #[Groups(["User:write"])]
    #[Assert\NotBlank()]
    public string $phone;


}
