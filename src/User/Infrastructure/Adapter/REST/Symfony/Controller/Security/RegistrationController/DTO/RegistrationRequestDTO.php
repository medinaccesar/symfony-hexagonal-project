<?php

declare(strict_types=1);

namespace User\Infrastructure\Adapter\REST\Symfony\Controller\Security\RegistrationController\DTO;

use Common\Infrastructure\Adapter\REST\Symfony\Request\RequestDTO;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

class RegistrationRequestDTO implements RequestDTO, PasswordAuthenticatedUserInterface
{
    public ?string $username;
    public ?string $password;
    public ?array $roles;

    public function __construct(Request $request)
    {
        $this->username = $request->request->get('username');
        $this->password = $request->request->get('password');

        $roles = $request->request->get('roles');
        $this->roles = $roles !== null ? json_decode($roles, true) : [];
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \InvalidArgumentException('Invalid JSON format for roles.');
        }
    }

    //PasswordAuthenticatedUserInterface implementation
    public function getPassword(): ?string
    {
        return $this->getPassword();
    }
}
