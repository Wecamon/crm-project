<?php

namespace App\State;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Entity\User;
use App\Repository\UserRepository;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;

class PatchUserProcessor implements ProcessorInterface
{
    public function __construct(private EntityManagerInterface $em, private UserRepository $userRepository)
    {
    }

    public function process($input, Operation $operation, array $uriVariables = [], array $context = []): User
    {
        $user = $this->userRepository->findOneBy(['id' => $context['object_to_populate']->getId()]);
        
        if($input->email){
            $user->setEmail($input->email);
        }
        if($input->phone){
            $user->setPhone($input->phone);
        }
        if($input->firstname){
            $user->setFirstname($input->firstname);
        }
        if($input->lastname){
            $user->setLastname($input->lastname);
        }
        $user->setUpdatedAt(new DateTimeImmutable());

        return $user;
    }
}
