<?php

declare(strict_types=1);

namespace Common\Domain\Validation\Trait;

use Common\Domain\Validation\ConstraintType;
use Common\Domain\Validation\Formatter\ValidationErrorFormatter;

trait LengthValidationTrait
{
    /**
     * Validates the length of a string.
     * Checks if the given string's length falls within the specified range. If the string length is outside
     * the range, a formatted validation error message is returned.
     *
     * @param string|null $value The string to validate.
     * @param int         $min   The minimum length.
     * @param int         $max   The maximum length.
     * @param string      $fieldName The name of the field being validated, used in the error message.
     *
     * @return array An array containing the validation error message, if any.
     */
    public function validateLength(?string $value, int $min, int $max, string $fieldName): array
    {
        $length = strlen($value);
        if ($length < $min || $length > $max) {
            return ValidationErrorFormatter::format(
                ConstraintType::LENGTH,
                $fieldName,
                $value
            );
        }
        return [];
    }
}
