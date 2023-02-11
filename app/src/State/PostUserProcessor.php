<?php

namespace App\State;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use ApiPlatform\Validator\ValidatorInterface;
use App\Entity\User;

class PostUserProcessor implements ProcessorInterface
{
    public function __construct(private ValidatorInterface $validator)
    {
        
    }
    /**
     * @param PostUserInput $data
     */
    public function process($data, Operation $operation, array $uriVariables = [], array $context = []): User
    {
        $this->validator->validate($data);
        
        return new User(
            $data->email,
            $data->phone,
            $data->firstname,
            $data->lastname
        );
    }
}
