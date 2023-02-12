<?php

namespace App\State\Processor\User;

use ApiPlatform\Doctrine\Common\State\PersistProcessor;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use ApiPlatform\Validator\ValidatorInterface;
use App\Entity\User;
use App\State\Processor\PersistProcessorInterface;

class PostUserProcessor implements PersistProcessorInterface
{
    public function __construct(
        private PersistProcessor $persistProcessor,
        private ValidatorInterface $validator
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
            $data->lastname
        );

        $this->persistProcessor->process($user, $operation, $uriVariables, $context);

        return $user;
    }
}
