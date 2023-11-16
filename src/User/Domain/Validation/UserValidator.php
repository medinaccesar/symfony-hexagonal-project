<?php

namespace User\Domain\Validation;

use Common\Domain\Exception\ValidationException;
use Common\Domain\Validation\Trait\CommonValidationTrait;
use User\Domain\Validation\Trait\RolesValidationTrait;

class UserValidator
{
    use CommonValidationTrait;
    use RolesValidationTrait;

    public function validateAndThrows(object $user): void
    {
        $violations = $this->validateUsername($user->username);
        if (!empty($violations)) {
            throw ValidationException::createFromViolations(['violations' => $violations]);
        }
    }

    private function validateUsername(?string $username): array
    {
        $violations = [];
        $notBlankViolation = $this->validateNotBlank($username, 'username');
        if (!empty($notBlankViolation)) {
            $violations[] = $notBlankViolation;
        }
        if (empty($violations)) {
            $lengthViolation = $this->validateLength($username, 4, 20, 'username');
            if (!empty($lengthViolation)) {
                $violations[] = $lengthViolation;
            }
        }
        return $violations;
    }
}
