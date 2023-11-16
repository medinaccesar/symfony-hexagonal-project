<?php

namespace Common\Domain\Validation\Trait;

use Common\Domain\Validation\ConstraintTypes;
use Common\Domain\Validation\Formatter\ValidationFormatter;

trait RangeValidationTrait
{
    public function validateRange(float|int $value, float|int $min, float|int $max, string $fieldName): array
    {
        if ($value < $min || $value > $max) {
            return ValidationFormatter::format(
                $fieldName,
                ConstraintTypes::RANGE,
                "{$fieldName} must be between {$min} and {$max}.",
                $value);
        }
        return [];
    }
}
