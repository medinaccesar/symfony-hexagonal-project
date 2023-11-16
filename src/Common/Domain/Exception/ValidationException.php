<?php

namespace Common\Domain\Exception;

use RuntimeException;
use Throwable;

class ValidationException extends RuntimeException
{
    const VALIDATION_ERROR_CODE = 422;
    const VALIDATION_MESSAGE = 'Validation failed';

    private array $violations;

    public function __construct(array $violations, string $message = self::VALIDATION_MESSAGE , int $code = self::VALIDATION_ERROR_CODE, Throwable $previous = null)
    {
        $this->violations = $violations;

        parent::__construct($message, $code, $previous);
    }

    public function getViolations(): array
    {
        return $this->violations;
    }

    public static function createFromViolations(array $violations): static
    {
        return new static($violations, self::VALIDATION_MESSAGE);
    }
}
