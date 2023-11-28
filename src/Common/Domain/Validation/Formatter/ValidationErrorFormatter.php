<?php

declare(strict_types=1);

namespace Common\Domain\Validation\Formatter;

class ValidationErrorFormatter
{
    /**
     * Format a validation message.
     *
     * @param string $field the field associated with the validation
     *
     * @return array an associative array containing the field and message
     */
    public static function format(string $constraint, string $field, $value): array
    {
        return [
            'constraint' => $constraint,
            'field' => $field,
            'value' => $value,
        ];
    }
}
