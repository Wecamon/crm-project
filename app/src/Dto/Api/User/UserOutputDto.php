<?php

declare(strict_types=1);

namespace App\Dto\Api\User;

use DateTimeInterface;
use Symfony\Component\Serializer\Annotation\Groups;

class UserOutputDto
{
    #[Groups(['User:read'])]
    public int $id;

    #[Groups(['User:read'])]
    public string $firstname;

    #[Groups(['User:read'])]
    public ?string $lastname = null;

    #[Groups(['User:read'])]
    public ?string $email = null;

    #[Groups(['User:read'])]
    public string $phone;

    #[Groups(['User:read'])]
    public DateTimeInterface $createdAt;

    public function __construct(
        int $id,
        string $firstname,
        ?string $lastname,
        ?string $email,
        string $phone,
        DateTimeInterface $createdAt
    ) {
        $this->id = $id;
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->email = $email;
        $this->phone = $phone;
        $this->createdAt = $createdAt;
    }
}
