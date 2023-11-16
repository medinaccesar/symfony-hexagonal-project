<?php

namespace User\Domain\Security;

readonly class Roles
{
    const ALLOWED_ROLES =  ['ROLE_ADMIN', 'ROLE_USER'];

    public static function getRoles(): array
    {
        return self::ALLOWED_ROLES;
    }

}