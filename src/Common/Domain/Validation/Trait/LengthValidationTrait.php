<?php

namespace Common\Domain\Validation\Trait;

use Common\Domain\Validation\Formatter\ValidationFormatter;

trait LengthValidationTrait
{
    public function validateLength(?string $value, int $min, int $max, string $fieldName): array
    {
        $length = strlen($value);
        if ($length < $min || $length > $max) {
            return ValidationFormatter::format("{$fieldName} must be between {$min} and {$max} characters long.", $fieldName);
        }
        return [];
    }
}