<?php

declare(strict_types=1);

namespace App\State\Processor\User;

use ApiPlatform\Doctrine\Common\State\PersistProcessor;
use ApiPlatform\Metadata\Operation;
use App\DataTransformer\Api\User\UserInputPostDataTransformer;
use App\DataTransformer\Api\User\UserOutputGetDataTransformer;
use App\Dto\Api\User\UserInputPostDto;
use App\Dto\Api\User\UserOutputDto;
use App\State\Processor\PersistProcessorInterface;

class PostUserProcessor implements PersistProcessorInterface
{
    public function __construct(
        private UserInputPostDataTransformer $postDataTransformer,
        private UserOutputGetDataTransformer $getDataTransformer,
        private PersistProcessor $persistProcessor,
    ) {
    }

    /**
     * @param UserInputPostDto $data
     */
    public function process($data, Operation $operation, array $uriVariables = [], array $context = []): UserOutputDto
    {
        $user = $this->postDataTransformer->transform($data);

        $this->persistProcessor->process($user, $operation, $uriVariables, $context);

        return $this->getDataTransformer->transform($user);
    }
}
