<?php

declare(strict_types=1);

namespace Common\Domain\Validation\Formatter;

class ValidationErrorFormatter
{
    /**
     * Format a validation message.
     *
     * @param string $field The field associated with the validation.
     * @param string $message The validation message.
     * @return array An associative array containing the field and message.
     */
    public static function format(string $constraint, string $field, $value): array
    {
        return [
            'constraint' => $constraint,
            'field' => $field,
            'value' => $value
        ];
    }
}