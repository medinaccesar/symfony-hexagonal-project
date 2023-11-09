<?php

namespace Common\Infrastructure\Service\Symfony\Uuid;

use Common\Domain\Service\Interface\UuidGeneratorServiceInterface;
use Symfony\Component\Uid\Uuid;

class UuidGeneratorServiceService implements UuidGeneratorServiceInterface
{
    public function generateUuid(): string
    {
        return Uuid::v4()->toRfc4122();
    }

    public function validateUuid($uuid): string
    {
        return Uuid::isValid($uuid);
    }
}