<?php

declare(strict_types=1);

namespace App\State\Provider\Appointment;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\DataTransformer\Api\Appointment\AppointmentOutputDataTransformer;
use App\Dto\Api\Appointment\AppointmentOutputDto;
use App\Entity\Appointment;
use App\State\Provider\CollectionProviderInterface;
use Symfony\Bundle\SecurityBundle\Security;

class AppointmentsMeProvider implements CollectionProviderInterface
{
    public function __construct(
        private ProviderInterface $collectionProvider,
        private AppointmentOutputDataTransformer $dataTransformer,
        private Security $security,
    ) {
    }

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
        return array_map(
            fn (Appointment $appointment): AppointmentOutputDto => $this->dataTransformer->transform($appointment),
            iterator_to_array(($this->collectionProvider->provide($operation, $uriVariables, $context))->getIterator())
        );
    }
}
