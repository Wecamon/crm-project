<?php

declare(strict_types=1);

namespace App\ApiPlatform\Decorator;

use ApiPlatform\Metadata\Patch;
use ApiPlatform\Serializer\AbstractItemNormalizer;
use ApiPlatform\Serializer\InputOutputMetadataTrait;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\SerializerAwareTrait;

class InitializerDecorator implements DenormalizerInterface
{
    use InputOutputMetadataTrait;
    use SerializerAwareTrait;

    public function __construct(
        private AbstractItemNormalizer $decoratedNormalizer,
        private iterable $stateProcessors
    ) {
    }

    public function denormalize(mixed $data, string $class, string $format = null, array $context = []): mixed
    {
        dd($this->decoratedNormalizer);

        if (!$context['operation'] instanceof Patch ||
            !($inputClass = $this->getInputClass($context))) {
            return $this->decoratedNormalizer->denormalize($data, $class, $format, $context);
        }
        dd(iterator_to_array($this->stateProcessors));
    }

    public function supportsDenormalization(mixed $data, string $type, ?string $format = null)
    {
        return $this->decoratedNormalizer->supportsDenormalization($data, $type, $format);
    }
}
