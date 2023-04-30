<?php

declare(strict_types=1);

namespace App\State\Provider\User;

use ApiPlatform\Exception\ItemNotFoundException;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\DataTransformer\Api\User\UserOutputGetDataTransformer;
use App\Dto\Api\User\UserOutputDto;
use App\State\Provider\ItemProviderInterface;

class UserProvider implements ItemProviderInterface
{
    public function __construct(
        private ProviderInterface $itemProvider,
        private UserOutputGetDataTransformer $dataTransformer
    ) {
    }

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): UserOutputDto
    {
        $user = $this->itemProvider->provide($operation, $uriVariables, $context) ??
            throw new ItemNotFoundException('Not Found');

        return $this->dataTransformer->transform($user);
    }
}
