<?php

declare(strict_types=1);

namespace User\Domain\Validation\Trait;

use Common\Domain\Validation\ConstraintType;
use Common\Domain\Validation\Formatter\ValidationErrorFormatter;
use User\Domain\Security\AllowedRoles;

trait RolesValidationTrait
{
    /**
     * Validates an array of roles.
     *
     * @param array $roles
     * @return array
     */
    public function validateRoles(array $roles): array
    {
        $errors = [];

        foreach ($roles as $role) {
            if (!$this->isRoleValid($role)) {
                $errors[] = ValidationErrorFormatter::format(
                    'roles',
                    ConstraintType::ROLE,
                    $role
                );
            }
        }

        return $errors;
    }

    /**
     * Checks if a role is valid.
     *
     * @param string $role
     * @return bool
     */
    protected function isRoleValid(string $role): bool
    {
        return in_array($role, AllowedRoles::getRoles());
    }
}


