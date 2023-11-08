<?php

namespace Core\Validation\Trait;

use Core\Exception\InvalidArgumentException;

trait AssertAllowedRolesTrait
{
    const ALLOWED = ['ROLE_USER', 'ROLE_ADMIN'];

    public function assertAllowedRoles(array $values): void
    {
        $args = array_combine(self::ALLOWED, $values);
        $notAllowedValues = [];
        foreach ($args as $key => $value) {
            if (is_null($value)) {
                $notAllowedValues[] = $key;
            }
        }

        if (!empty($notAllowedValues)) {
            throw InvalidArgumentException::createFromArray($notAllowedValues);
        }
    }
}