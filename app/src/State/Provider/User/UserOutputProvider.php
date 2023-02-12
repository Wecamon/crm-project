<?php

namespace App\State\Provider\User;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\State\Provider\ItemProviderInterface;
use App\Dto\UserOutput;

class UserOutputProvider implements ItemProviderInterface
{
    public function __construct(private ProviderInterface $itemProvider)
    {
    }

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): UserOutput
    {
        $user = $this->itemProvider->provide($operation, $uriVariables, $context);

        return new UserOutput(
            $user->getId(),
            $user->getFirstname(),
            $user->getLastname(),
            $user->getEmail(),
            $user->getPhone(),
            $user->getCreatedAt()
        );
    }
}
