<?php

declare(strict_types=1);

namespace App\ApiPlatform\Decorator;

use ApiPlatform\Metadata\Patch;
use ApiPlatform\Serializer\AbstractItemNormalizer;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\SerializerAwareInterface;
use Symfony\Component\Serializer\SerializerAwareTrait;

class InitializerDecorator implements DenormalizerInterface, SerializerAwareInterface
{
    use SerializerAwareTrait;

    public function __construct(
        private AbstractItemNormalizer $decoratedNormalizer,
        private iterable $stateProcessors
    ) {
    }

    public function denormalize(mixed $data, string $class, string $format = null, array $context = []): mixed
    {
        $this->decoratedNormalizer->setSerializer($this->serializer);

        if (!($operation = $context['operation']) instanceof Patch || !$operation->getInput()) {
            return $this->decoratedNormalizer->denormalize($data, $class, $format, $context);
        }

        foreach ($this->stateProcessors as $stateProcessor) {
            if ($stateProcessor::class === $operation->getProcessor()) {
                $initializedObject = $stateProcessor->initialize($data, $class, $format, $context);

                foreach ($data as $inputField => $inputValue) {
                    if (property_exists($initializedObject, $inputField)) {
                        try {
                            $initializedObject->$inputField = $inputValue;
                        } catch (\TypeError $error) {
                            throw new UnprocessableEntityHttpException($error->getMessage());
                        }
                    }
                }

                return $initializedObject;
            }
        }
    }

    public function supportsDenormalization(mixed $data, string $type, ?string $format = null, array $context = []): bool
    {
        return $this->decoratedNormalizer->supportsDenormalization($data, $type, $format);
    }
}
