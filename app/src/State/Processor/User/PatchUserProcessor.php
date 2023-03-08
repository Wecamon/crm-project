<?php

namespace App\State\Processor\User;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Dto\PatchUserInput;
use App\Repository\UserRepository;
use App\State\Processor\PersistProcessorInitializerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class PatchUserProcessor implements PersistProcessorInitializerInterface
{
    public function __construct(
        private ProcessorInterface $persistProcessor,
        private ValidatorInterface $validator,
        private UserRepository $userRepository,
        private UserPasswordHasherInterface $hasher
    ) {
    }

    /**
     * @param PatchUserInput $data
     */
    public function process($data, Operation $operation, array $uriVariables = [], array $context = []): array|object|null
    {
        $this->validator->validate($data);

        $user = $this->userRepository->find($uriVariables['id']);
        $user->setFirstname($data->firstname);
        $user->setLastname($data->lastname);
        $user->setEmail($data->email);
        $user->setPhone($data->phone);
        
        if ($data->password) {
            $user->setPassword($data->password, $this->hasher);
        }

        $this->persistProcessor->process($user, $operation, $uriVariables, $context);

        return $user;
    }

    public function initialize(mixed $data, string $class, ?string $format = null, array $context = []): object
    {
        $user = $context[AbstractNormalizer::OBJECT_TO_POPULATE];

        $dto = new PatchUserInput();
        $dto->email = $user->getEmail();
        $dto->firstname = $user->getFirstname();
        $dto->lastname = $user->getLastname();
        $dto->phone = $user->getPhone();

        return $dto;
    }
}
