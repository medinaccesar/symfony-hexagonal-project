<?php

namespace Common\Domain\Validation\Trait;

trait CommonValidationTrait
{
    /**
     * Validate that a string is not blank.
     *
     * @param string|null $value The value to validate.
     * @param string $fieldName The name of the field being validated.
     *
     * @return array An array of error messages. Empty array if validation passes.
     */
    public function validateNotBlank(?string $value, string $fieldName): array
    {
        return empty($value) ? ["{$fieldName} should not be blank."] : [];
    }


    /**
     * Validate the length of a string.
     *
     * @param string|null $value The value to validate.
     * @param int $min The minimum allowed length.
     * @param int $max The maximum allowed length.
     * @param string $fieldName The name of the field being validated.
     *
     * @return array An array of error messages. Empty array if validation passes.
     */
    public function validateLength(?string $value, int $min, int $max, string $fieldName): array
    {
        $length = strlen($value);
        if ($length < $min || $length > $max) {
            return ["{$fieldName} must be between {$min} and {$max} characters long."];
        }
        return [];
    }


    /**
     * Validate that a value is not null.
     *
     * @param mixed
     * @param string
     * @return array
     */
    public function validateNotNull($value, string $fieldName): array
    {
        return is_null($value) ? ["{$fieldName} should not be null."] : [];
    }
    

    /**
     * Validate that a value is within a specified range.
     *
     * @param int|float 
     * @param int|float
     * @param int|float
     * @param string
     * @return array
     */
    public function validateRange($value, $min, $max, string $fieldName): array
    {
        if ($value < $min || $value > $max) {
            return ["{$fieldName} must be between {$min} and {$max}."];
        }
        return [];
    }
}
