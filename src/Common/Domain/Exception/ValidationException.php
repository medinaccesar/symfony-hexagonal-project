<?php

declare(strict_types=1);

namespace Common\Domain\Exception;

use Common\Domain\Exception\Constant\ExceptionMessage;
use Common\Domain\Exception\Constant\ExceptionType;

class ValidationException extends ApiException
{
    private array $violations;

    public function __construct(array $violations)
    {
        parent::__construct(422, ExceptionMessage::VALIDATION, ExceptionType::VALIDATION);
        $this->violations = $violations;
    }

    public function getViolations(): array
    {
        return $this->violations;
    }
}


