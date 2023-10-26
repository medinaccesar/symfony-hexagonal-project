<?php

namespace Core\Exception;

use DomainException;
use function sprintf;

class ResourceNotFoundException extends DomainException
{
    public static function createFromClassAndId(string $class, string $id): static
    {
        return new static(sprintf('Resource of type [%s] with ID [%s] not found', $class, $id));
    }
}
