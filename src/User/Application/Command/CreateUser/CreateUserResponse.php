<?php

declare(strict_types=1);

namespace User\Application\Command\CreateUser;

/**
 * CreateUserResponse represents the response returned after creating a user.
 * It primarily contains the unique identifier of the newly created user.
 */
final readonly class CreateUserResponse
{
    public function __construct(
        public string $id
    ) {
    }
}
