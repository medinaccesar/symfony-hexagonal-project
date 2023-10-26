<?php

namespace User\Application\Command\CreateUser\DTO;

readonly class CreateUserInputDTO
{
    private function __construct(
        public string $username,
        public string $password,
        public ?array $roles
    ) {
    }

    public static function create(string $username, string $password, ?array $roles): self
    {
        return new static($username, $password, $roles);
    }
}
