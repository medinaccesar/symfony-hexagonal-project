<?php

namespace Common\Domain\Validation\Trait;

use Common\Domain\Validation\ConstraintTypes;
use Common\Domain\Validation\Formatter\ValidationFormatter;

trait NotBlankValidationTrait
{
    public function validateNotBlank(?string $value, string $fieldName): array
    {
        if (empty($value)) {
            return ValidationFormatter::format(
                $fieldName,
                ConstraintTypes::NOT_BLANK,
                "{$fieldName} should not be blank.",
                $value);
        }
        return [];
    }
}