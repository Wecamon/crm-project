<?php

namespace App\State\Processor\User;

use ApiPlatform\Doctrine\Common\State\PersistProcessor;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\Validator\ValidatorInterface;
use App\Entity\User;
use App\State\Processor\PersistProcessorInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class PostUserProcessor implements PersistProcessorInterface
{
    public function __construct(
        private PersistProcessor $persistProcessor,
        private ValidatorInterface $validator,
        private UserPasswordHasherInterface $hasher
    ) {
    }

    /**
     * @param PostUserInput $data
     */
    public function process($data, Operation $operation, array $uriVariables = [], array $context = []): User
    {
        $this->validator->validate($data);

        $user = new User(
            $data->email,
            $data->phone,
            $data->firstname,
            $data->lastname,
            $data->password,
            $this->hasher
        );

        $this->persistProcessor->process($user, $operation, $uriVariables, $context);

        return $user;
    }
}
