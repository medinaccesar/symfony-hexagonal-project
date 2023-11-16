<?php

namespace Common\Domain\Exception;

use DomainException;
use function sprintf;

class DuplicateResourceException extends DomainException
{
    const DUPLICATE_ERROR_CODE = 409;

    public static function createFromValue(string $value): static
    {
        return new static(sprintf('Resource with value [%s] already exists.', $value), self::DUPLICATE_ERROR_CODE);
    }
}
