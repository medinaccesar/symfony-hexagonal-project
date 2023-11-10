<?php

namespace Common\Domain\Exception;
use RuntimeException;
use Throwable;

class ValidationException extends RuntimeException
{
    private array $violations;

    public function __construct(array $violations, string $message = 'Validation failed', int $code = 0, Throwable $previous = null)
    {
        $this->violations = $violations;

        parent::__construct($message, $code, $previous);
    }

    public function getViolations(): array
    {
        return $this->violations;
    }
}
