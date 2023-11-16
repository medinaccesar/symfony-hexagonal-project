<?php

namespace Common\Domain\Validation\Trait;

use Common\Domain\Validation\Formatter\ValidationFormatter;

trait NotNullValidationTrait
{
    public function validateNotNull(mixed $value, string $fieldName): array
    {
        if (is_null($value)) {
            return ValidationFormatter::format("{$fieldName} should not be null.", $fieldName);
        }
        return [];
    }

}