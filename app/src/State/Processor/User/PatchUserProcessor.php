<?php

namespace App\State\Processor\User;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Repository\UserRepository;
use App\State\Processor\PersistProcessorInitializerInterface;
use App\State\Processor\PersistProcessorInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class PatchUserProcessor implements PersistProcessorInterface, PersistProcessorInitializerInterface
{
    public function __construct(
        private ProcessorInterface $persistProcessor,
        private ValidatorInterface $validator,
        private UserRepository $userRepository
    ) {
    }

    public function process($data, Operation $operation, array $uriVariables = [], array $context = []): array|object|null
    {
        $this->validator->validate($data);

        dd($data);
        $user = $this->userRepository->find($uriVariables['id']);

        $this->persistProcessor->process($user, $operation, $uriVariables, $context);

        return $user;
    }
}
