<?php

namespace User\Domain\Validation;

use Common\Domain\Exception\ValidationException;

class UserValidator
{
    public function validateAndThrows(object $user): bool
    {
        $errors = [];

        $errors['username'] = $this->validateUsername($user->username);
        $errors['password'] = $this->validatePassword($user->password);
        $errors['roles'] = $this->validateRoles($user->roles);

        // Filtra los errores vacíos
        $errors = array_filter($errors);

        if (!empty($errors)) {
            throw ValidationException::createFromViolations($errors);
        }

        return true;
    }

    private function validateUsername(?string $username): array
    {
        $errors = [];
        if (empty($username)) {
            $errors[] = "Username should not be blank.";
        } elseif (strlen($username) < 4 || strlen($username) > 50) {
            $errors[] = "Username must be between 4 and 50 characters long.";
        }
        return $errors;
    }

    private function validatePassword(?string $password): array
    {
        $errors = [];
        if (empty($password)) {
            $errors[] = "Password should not be blank.";
        } elseif (strlen($password) < 8 || strlen($password) > 10) {
            $errors[] = "Password must be between 8 and 10 characters long.";
        }
        return $errors;
    }

    private function validateRoles(?array $roles): array
    {
        $errors = [];
        if (empty($roles)) {
            $errors[] = "Roles should not be empty.";
        } else {
            foreach ($roles as $role) {
                if (!in_array($role, ['ROLE_USER', 'ROLE_ADMIN'])) {
                    $errors[] = "Invalid role: {$role}";
                }
            }
        }
        return $errors;
    }
}
