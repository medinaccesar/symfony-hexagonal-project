<?php

namespace Common\Domain\Exception;

use DomainException;
use function sprintf;

class DuplicateResourceException extends DomainException
{
    const DUPLICATE_RESOURCE_ERROR_CODE = 403;
    public static function createFromValue(string $value): static
    {
        return new static(sprintf('Resource with value [%s] already exists.', $value), self::DUPLICATE_RESOURCE_ERROR_CODE);
    }
}
