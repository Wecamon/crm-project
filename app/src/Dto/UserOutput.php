<?php

namespace App\Dto;

use DateTimeInterface;
use Symfony\Component\Serializer\Annotation\Groups;

class UserOutput
{
    #[Groups(["User:read"])]
    public int $id;

    #[Groups(["User:read"])]
    public string $firstname;
    
    #[Groups(["User:read"])]
    public ?string $lastname;

    #[Groups(["User:read"])]
    public ?string $email;

    #[Groups(["User:read"])]
    public string $phone;

    #[Groups(["User:read"])]
    public DateTimeInterface $createdAt;

    public function __construct(
        int $id,
        string $firstname,
        ?string $lastname,
        ?string $email,
        string $phone,
        DateTimeInterface $createdAt
    ){
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->email = $email;
        $this->phone = $phone;
        $this->createdAt = $createdAt;   
    }
}
