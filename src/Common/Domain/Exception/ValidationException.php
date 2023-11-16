<?php

namespace Common\Domain\Exception;

use Common\Domain\Exception\Interface\ViolationExceptionInterface;
use RuntimeException;
use Throwable;

class ValidationException extends RuntimeException implements ViolationExceptionInterface
{
    const VALIDATION_ERROR_CODE = 422;
    const VALIDATION_MESSAGE = 'Validation failed';
    private array $violations;

    public static function createFromViolations(array $violations): static
    {
        $instance = new static(self::VALIDATION_MESSAGE, self::VALIDATION_ERROR_CODE);
        $instance->violations = $violations;
        return $instance;
    }

    public function getViolations(): array
    {
        return $this->violations;
    }
}
