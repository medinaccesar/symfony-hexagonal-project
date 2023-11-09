<?php

namespace Common\Domain\Validation\Trait;

use Common\Domain\Exception\InvalidArgumentException;

trait AssertAllowedRolesTrait
{
    const ALLOWED = ['ROLE_USER', 'ROLE_ADMIN'];

    public function assertAllowedRoles(array $roles): void
    {
        $notAllowedRoles = array_diff($roles, self::ALLOWED);

        if (!empty($notAllowedRoles)) {
            throw InvalidArgumentException::createFromArray($notAllowedRoles);
        }
    }
}
