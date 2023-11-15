<?php

namespace Common\Domain\Validation\Trait;

trait BlankValidationTrait
{
    public function validateNotBlank(?string $value, string $fieldName): array
    {
        return empty($value) ? ["{$fieldName} should not be blank."] : [];
    }
}