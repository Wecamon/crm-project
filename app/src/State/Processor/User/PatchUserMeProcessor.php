<?php

declare(strict_types=1);

namespace App\State\Processor\User;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\DataTransformer\Api\User\UserInputPatchDataTransformer;
use App\DataTransformer\Api\User\UserOutputGetDataTransformer;
use App\Dto\Api\User\UserInputPatchDto;
use App\State\Processor\PersistProcessorInitializerInterface;
use Symfony\Bundle\SecurityBundle\Security;

class PatchUserMeProcessor implements PersistProcessorInitializerInterface
{
    public function __construct(
        private ProcessorInterface $persistProcessor,
        private UserInputPatchDataTransformer $patchDataTransformer,
        private UserOutputGetDataTransformer $getDataTransformer,
        private Security $security
    ) {
    }

    /**
     * @param UserInputPatchDto $data
     */
    public function process($data, Operation $operation, array $uriVariables = [], array $context = []): array|object|null
    {
        $user = $this->security->getUser();

        $user = $this->patchDataTransformer->transform($data, $user);

        $this->persistProcessor->process($user, $operation, $uriVariables, $context);

        return $this->getDataTransformer->transform($user);
    }

    public function initialize(mixed $data, string $class, ?string $format = null, array $context = []): object
    {
        $user = $this->security->getUser();

        $dto = new UserInputPatchDto();
        $dto->email = $user->getEmail();
        $dto->firstname = $user->getFirstname();
        $dto->lastname = $user->getLastname();
        $dto->phone = $user->getPhone();

        return $dto;
    }
}
