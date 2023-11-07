<?php

namespace User\Application\Command\CreateUser\DTO;

use User\Adapter\Framework\HTTP\Controller\CreateUserController\DTO\CreateUserRequestDTO;

readonly class CreateUserInputDTO
{
    private function __construct(
        public string $username,
        public string $password,
        public ?array $roles
    ) {
    }

    public static function create(CreateUserRequestDTO $requestDTO): self
    {
        return new static(
            $requestDTO->username,
            $requestDTO->password,
            $requestDTO->roles);
    }
}
