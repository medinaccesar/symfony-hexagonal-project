<?php

namespace User\Application\Query\GetUserById\DTO;

use User\Domain\Model\User;

readonly class GetUserByIdOutputDTO
{
    private function __construct(
        public string $id,
        public string $username,
        public string $password,
        public array  $roles,
    )
    {
    }

    public static function create(User $user): self
    {
        return new self(
            $user->getId(),
            $user->getUsername(),
            $user->getPassword(),
            $user->getRoles()
        );
    }
}
