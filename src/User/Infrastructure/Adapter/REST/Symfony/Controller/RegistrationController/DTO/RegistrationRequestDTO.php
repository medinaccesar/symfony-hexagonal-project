<?php

declare(strict_types=1);

namespace User\Infrastructure\Adapter\REST\Symfony\Controller\RegistrationController\DTO;

use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

class RegistrationRequestDTO implements PasswordAuthenticatedUserInterface
{
    public ?string $username = null;
    public ?string $password = null;
    public ?array $roles = null;

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setUsername(?string $username): void
    {
        $this->username = $username;
    }

    public function setPassword(?string $password): void
    {
        $this->password = $password;
    }

    public function setRoles(?array $roles): void
    {
        $this->roles = $roles;

    }
}
