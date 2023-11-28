<?php

declare(strict_types=1);

namespace User\Domain\Security;

readonly class AllowedRoles
{
    public const ALLOWED_ROLES = ['ROLE_ADMIN', 'ROLE_USER'];

    public static function getRoles(): array
    {
        return self::ALLOWED_ROLES;
    }
}
