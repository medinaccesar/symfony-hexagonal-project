<?php

namespace Common\Domain\Validation\Trait;

trait LengthValidationTrait
{
    /**
     * @param string|null $value
     * @param int $min
     * @param int $max
     * @param string $fieldName
     * @return string[]|void
     */
    public function validateLength(?string $value, int $min, int $max, string $fieldName)
    {
        $length = strlen($value);
        if ($length < $min || $length > $max) {
            return ["{$fieldName} must be between {$min} and {$max} characters long."];
        }
    }
}