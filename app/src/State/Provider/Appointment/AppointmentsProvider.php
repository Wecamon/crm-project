<?php

declare(strict_types=1);

namespace App\State\Provider\Appointment;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\DataTransformer\Api\Appointment\AppointmentOutputDataTransformer;
use App\Dto\Api\Appointment\AppointmentOutputDto;
use App\Entity\Appointment;
use App\State\Provider\CollectionProviderInterface;

class AppointmentsProvider implements CollectionProviderInterface
{
    public function __construct(
        private ProviderInterface $collectionProvider,
        private AppointmentOutputDataTransformer $dataTransformer,
    ) {
    }

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
        return array_map(
            fn (Appointment $user): AppointmentOutputDto => $this->dataTransformer->transform($user),
            iterator_to_array(($this->collectionProvider->provide($operation, $uriVariables, $context))->getIterator())
        );
    }
}
