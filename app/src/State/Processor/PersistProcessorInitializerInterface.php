<?php

declare(strict_types=1);

namespace App\State\Processor;

interface PersistProcessorInitializerInterface extends PersistProcessorInterface
{
    public function initialize(mixed $data, string $class, string $format = null, array $context = []): object;
}
