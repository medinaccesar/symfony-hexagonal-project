<?php

namespace Common\Domain\Validation\Trait;

use Common\Domain\Validation\ConstraintTypes;
use Common\Domain\Validation\Formatter\ValidationFormatter;

trait LengthValidationTrait
{
    public function validateLength(?string $value, int $min, int $max, string $fieldName): array
    {
        $length = strlen($value);
        if ($length < $min || $length > $max) {
            return ValidationFormatter::format(
                $fieldName,
                ConstraintTypes::LENGTH,
                "{$fieldName} must be between {$min} and {$max} characters long.",
                $value);
        }
        return [];
    }
}