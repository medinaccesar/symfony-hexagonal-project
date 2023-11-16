<?php

namespace Common\Domain\Exception;

use DomainException;
use function sprintf;

class ResourceNotFoundException extends DomainException
{
    const NOT_FOUND_ERROR_CODE = 404;

    public static function createFromClassAndId(string $class, string $id): static
    {
        return new static(sprintf('Resource of type [%s] with ID [%s] not found', $class, $id), self::NOT_FOUND_ERROR_CODE);
    }
}
