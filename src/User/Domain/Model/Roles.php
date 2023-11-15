<?php

namespace User\Domain\Model;

readonly class Roles
{
    const ALLOWED_ROLES =  ['ROLE_ADMIN', 'ROLE_USER'];

    public static function getRoles() {
        return self::ALLOWED_ROLES;
    }

}