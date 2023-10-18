<?php

namespace User\Application\UseCase;

use User\Domain\Repository\UserRepositoryInterface;
use User\Domain\Model\User;

class CreateUserInputDTO
{
    private function __construct(
        public readonly string $username,
        public readonly string $password,
        public readonly ?array $roles
    ) {
    }

    public static function create(string $username, string $password, ?array $roles): self
    {
        return new static($username, $password, $roles);
    }
}
