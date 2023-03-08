<?php

namespace App\State\Provider\User;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Dto\UsersOutput;
use App\Entity\User;
use App\State\Provider\CollectionProviderInterface;

class UsersOutputProvider implements CollectionProviderInterface
{
    public function __construct(private ProviderInterface $collectionProvider)
    {
    }

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): array
    {
        return array_map(
            static fn (User $user): UsersOutput =>
                new UsersOutput(
                    $user->getId(),
                    $user->getFirstname(),
                    $user->getLastname(),
                    $user->getEmail(),
                    $user->getPhone(),
                    $user->getCreatedAt()
                )
            ,
            iterator_to_array(($this->collectionProvider->provide($operation, $uriVariables, $context))->getIterator())
        );
    }
}
