<?php

namespace Common\Domain\Exception;

use Common\Domain\Exception\Interface\ViolationExceptionInterface;
use DomainException;
use function sprintf;

class DuplicateValidationResourceException extends DomainException implements ViolationExceptionInterface
{
    const DUPLICATE_ERROR_CODE = 409;
    private string $value;
    private string $key;

    public static function createFromValue(string $value, string $key): static
    {
        $instance = new static(sprintf('Resource with value %s already exists.', $value), self::DUPLICATE_ERROR_CODE);
        $instance->value = $value;
        $instance->key = $key;

        return $instance;
    }

    /**
     * Returns violations related to the exception.
     * @return array
     */
    public function getViolations(): array
    {
        return [
            [
                'field' => $this->key,
                'message' => $this->value
            ]
        ];
    }
}
