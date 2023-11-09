<?php

namespace Common\Infrastructure\Service\Symfony\Uuid;

use Common\Domain\Service\Interface\UuidGeneratorInterface;
use Symfony\Component\Uid\Uuid;

class UuidGeneratorService implements UuidGeneratorInterface
{
    public function generateUuid(): string
    {
        return Uuid::v4()->toRfc4122();
    }
}