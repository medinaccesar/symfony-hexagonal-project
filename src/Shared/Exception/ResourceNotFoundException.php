<?php

namespace Shared\Exception;

class ResourceNotFoundException extends \DomainException
{
    public static function createFromClassAndId(string $class, string $id): static
    {
        return new static(\sprintf('Resource of type [%s] with ID [%s] not found', $class, $id));
    }
}
