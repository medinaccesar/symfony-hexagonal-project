<?php

namespace User\Domain\Validation;

use Common\Domain\Exception\ValidationException;
use Common\Domain\Validation\Trait\CommonValidationTrait;
use User\Domain\Validation\Trait\RolesValidationTrait;

class UserValidator
{
    use CommonValidationTrait;
    use RolesValidationTrait;

    
    public function validateAndThrows(object $user)
    {
        $violations = [];

        $violations = array_merge($violations, $this->validateNotBlank($user->username, 'username'));
        $violations = array_merge($violations, $this->validateLength($user->username, 4, 20, 'username'));
        $violations = array_merge($violations, $this->validateNotNull($user->password, 'password'));
        $violations = array_merge($violations, $this->validateRange(strlen($user->password), 6, 20, 'password'));

        $violations = array_filter($violations);

        if (!empty($violations)) {
            throw ValidationException::createFromViolations($violations);
        }

    }

 
    
}
