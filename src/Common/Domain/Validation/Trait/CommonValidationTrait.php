<?php

namespace Common\Domain\Validation\Trait;

trait CommonValidationTrait
{
    /**
     * Generate a validation error array in a format similar to Symfony's.
     *
     * @param string $message The error message.
     * @param string $fieldName The name of the field being validated.
     * @return array An array representing the validation error.
     */
    private function createValidationError(string $message, string $fieldName): array
    {
        return [
            'field' => $fieldName,
            'message' => $message
        ];
    }

    public function validateNotBlank(?string $value, string $fieldName): array
    {
        if (empty($value)) {
            return [$this->createValidationError("{$fieldName} should not be blank.", $fieldName)];
        }
        return [];
    }

    public function validateLength(?string $value, int $min, int $max, string $fieldName): array
    {
        $length = strlen($value);
        if ($length < $min || $length > $max) {
            return [$this->createValidationError("{$fieldName} must be between {$min} and {$max} characters long.", $fieldName)];
        }
        return [];
    }

    public function validateNotNull(mixed $value, string $fieldName): array
    {
        if (is_null($value)) {
            return [$this->createValidationError("{$fieldName} should not be null.", $fieldName)];
        }
        return [];
    }

    public function validateRange(float|int $value, float|int $min, float|int $max, string $fieldName): array
    {
        if ($value < $min || $value > $max) {
            return [$this->createValidationError("{$fieldName} must be between {$min} and {$max}.", $fieldName)];
        }
        return [];
    }
}
