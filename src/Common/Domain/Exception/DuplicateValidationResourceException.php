<?php

namespace Common\Domain\Exception;

use Common\Domain\Exception\Interface\ViolationExceptionInterface;
use Common\Domain\Validation\ConstraintTypes;
use Common\Domain\Validation\Formatter\ValidationFormatter;
use DomainException;
use function sprintf;

/**
 * Exception representing a duplicate resource validation error.
 *
 * This exception is thrown when an operation encounters a resource (identified by a field-value pair)
 * that already exists and such duplication is not allowed.
 */
class DuplicateValidationResourceException extends DomainException implements ViolationExceptionInterface
{
    const DUPLICATE_ERROR_CODE = 409;
    private string $value;
    private string $field;

    /**
     * Factory method to create an instance of the exception with a formatted message.
     *
     * @param string $value The value that is duplicated.
     * @param string $field The field where the duplication occurred.
     * @return static
     */
    public static function createFromValue(string $value, string $field): static
    {
        $instance = new static(sprintf('Resource with value %s already exists.', $value), self::DUPLICATE_ERROR_CODE);
        $instance->value = $value;
        $instance->field = $field;

        return $instance;
    }

    /**
     * Returns an array of violation details for this exception.
     * Each violation is formatted using the ValidationFormatter to ensure consistency.
     *
     * @return array An array containing the details of the violation.
     */
    public function getViolations(): array
    {
        return [
            ValidationFormatter::format(
                $this->field,
                ConstraintTypes::DUPLICATE,
                sprintf('Resource with value %s already exists.', $this->value),
                $this->value
            )
        ];
    }
}
