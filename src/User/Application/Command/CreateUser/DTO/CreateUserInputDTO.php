<?php

namespace User\Application\Command\CreateUser\DTO;
use Core\Validation\Trait\AssertAllowedRolesTrait;

class CreateUserInputDTO
{
    use AssertAllowedRolesTrait;

    private function __construct(
        public ?string $username,
        public ?string $password,
        public ?array $roles
    ) {
        if(null !== $this->roles){
            $this->assertAllowedRoles($this->roles);
        }
    }

    public static function create($username, $password, $roles): self
    {
        return new static(
            $username,
            $password,
            $roles
        );
    }
}
