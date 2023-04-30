<?php

declare(strict_types=1);

namespace App\State\Processor\User;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\DataTransformer\Api\User\UserInputPatchDataTransformer;
use App\DataTransformer\Api\User\UserOutputGetDataTransformer;
use App\Dto\Api\User\UserInputPatchDto;
use App\Repository\UserRepository;
use App\State\Processor\PersistProcessorInitializerInterface;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;

class PatchUserProcessor implements PersistProcessorInitializerInterface
{
    public function __construct(
        private ProcessorInterface $persistProcessor,
        private UserRepository $userRepository,
        private UserInputPatchDataTransformer $patchDataTransformer,
        private UserOutputGetDataTransformer $getDataTransformer,
    ) {
    }

    /**
     * @param UserInputPatchDto $data
     */
    public function process($data, Operation $operation, array $uriVariables = [], array $context = []): array|object|null
    {
        $user = $this->userRepository->find($uriVariables['id']);

        $user = $this->patchDataTransformer->transform($data, $user);

        $this->persistProcessor->process($user, $operation, $uriVariables, $context);

        return $this->getDataTransformer->transform($user);
    }

    public function initialize(mixed $data, string $class, ?string $format = null, array $context = []): object
    {
        $user = $context[AbstractNormalizer::OBJECT_TO_POPULATE];

        $dto = new UserInputPatchDto();
        $dto->email = $user->getEmail();
        $dto->firstname = $user->getFirstname();
        $dto->lastname = $user->getLastname();
        $dto->phone = $user->getPhone();

        return $dto;
    }
}
