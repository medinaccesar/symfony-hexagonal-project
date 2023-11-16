<?php

namespace Common\Domain\Exception;

use DomainException;
use function sprintf;

/**
 * Exception representing a scenario where a specified resource is not found.
 *
 * This exception should be thrown when a specific resource, identifiable by its class type and unique ID,
 * is requested but does not exist.
 */
class ResourceNotFoundException extends DomainException
{
    const NOT_FOUND_ERROR_CODE = 404;

    /**
     * Factory method to create an instance of the exception with a formatted message.
     *
     * @param string $class The class type of the resource that was not found.
     * @param string $id The unique identifier of the resource that was not found.
     * @return static An instance of ResourceNotFoundException with a custom message.
     */
    public static function createFromClassAndId(string $class, string $id): static
    {
        return new static(sprintf('Resource of type [%s] with ID [%s] not found.', $class, $id), self::NOT_FOUND_ERROR_CODE);
    }
}
