<?php

declare(strict_types=1);

namespace App\State\Provider\User;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\DataTransformer\Api\User\UserOutputGetDataTransformer;
use App\Dto\Api\User\UserOutputDto;
use App\Entity\User;
use App\State\Provider\CollectionProviderInterface;

class UsersProvider implements CollectionProviderInterface
{
    public function __construct(
        private ProviderInterface $collectionProvider,
        private UserOutputGetDataTransformer $dataTransformer,
    ) {
    }

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): array
    {
        return array_map(
            fn (User $user): UserOutputDto => $this->dataTransformer->transform($user),
            iterator_to_array(($this->collectionProvider->provide($operation, $uriVariables, $context))->getIterator())
        );
    }
}
