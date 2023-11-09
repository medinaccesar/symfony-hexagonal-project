<?php

namespace User\Application\Command\CreateUser;

readonly class CreateUserCommand
{
    public function __construct(
        public string $username,
        public string $password,
        public ?array $roles
    )
    {
    }
}