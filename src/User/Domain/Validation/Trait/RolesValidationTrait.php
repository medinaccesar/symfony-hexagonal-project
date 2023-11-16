<?php

namespace User\Domain\Validation\Trait;

use User\Domain\Security\Roles;

trait RolesValidationTrait
{

    /**
     * @param array $roles
     * @return array
     */
    public function validateRoles(array $roles): array
    {
        $errors = [];

        foreach ($roles as $role) {
            if (!$this->isRoleValid($role)) {
                $errors[] = "Invalid role: $role";
            }
        }

        return $errors;
    }

    /**
     * @param string $role
     * @return bool
     */
    protected function isRoleValid(string $role): bool
    {
        return in_array($role, Roles::getRoles());
    }
}

