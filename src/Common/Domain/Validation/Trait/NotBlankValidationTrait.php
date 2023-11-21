<?php

declare(strict_types=1);

namespace Common\Domain\Validation\Trait;

use Common\Domain\Validation\ConstraintType;
use Common\Domain\Validation\Formatter\ValidationErrorFormatter;

trait NotBlankValidationTrait
{
    /**
     * Validates that a string is not blank.
     * @param string|null $value     The string to validate.
     * @param string      $fieldName The name of the field for error messaging.
     * @return array An array containing a formatted validation error if the string is blank.
     */
    public function validateNotBlank(?string $value, string $fieldName): array
    {
        if (empty($value)) {
            return ValidationErrorFormatter::format(
                ConstraintType::NOT_BLANK,
                $fieldName,
                $value
            );
        }
        return [];
    }
}
