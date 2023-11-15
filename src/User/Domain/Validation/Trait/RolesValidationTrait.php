<?php

namespace User\Domain\Validation\Trait;

use User\Domain\Model\Roles;

trait RolesValidationTrait
{

    /**
     * Validate an array of roles.
     *
     * @param array 
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
     * Comprueba si un rol es válido.
     *
     * @param string
     * @param array 
     * @return bool
     */
    protected function isRoleValid(string $role): bool
    {
        return in_array($role, Roles::getRoles());
    }
}

