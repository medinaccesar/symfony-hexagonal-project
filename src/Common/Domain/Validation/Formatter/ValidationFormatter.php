<?php

namespace Common\Domain\Validation\Formatter;

class ValidationFormatter
{
    /**
     * Format a validation message.
     *
     * @param string $field The field associated with the validation.
     * @param string $message The validation message.
     * @return array An associative array containing the field and message.
     */
    public static function format(string $message, string $field): array
    {
        return [
            'field' => $field,
            'message' => $message
        ];
    }
}