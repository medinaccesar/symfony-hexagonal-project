<?php

namespace User\Application\Response;

use User\Domain\Model\User;

readonly class UserResponse
{
    public function __invoke(User $user): array
    {
        return [
            'username' => $user->getUsername(),
            // Add more properties here if needed
        ];
    }
}
