<?php

namespace App\State\Processor\User;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\State\Processor\PersistProcessorInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class PatchUserProcessor implements PersistProcessorInterface
{
    public function __construct(
        private ProcessorInterface $persistProcessor,
        private ValidatorInterface $validator
    ) {
    }

    public function process($data, Operation $operation, array $uriVariables = [], array $context = []): array|object|null
    {
        $this->validator->validate($data);

        $user = $context['previous_data'];
        $user->setEmail($data->email);

        // TODO: Finish patch processor.

        $user = $this->persistProcessor->process($user, $operation, $uriVariables, $context);

        return $user;
    }
}
