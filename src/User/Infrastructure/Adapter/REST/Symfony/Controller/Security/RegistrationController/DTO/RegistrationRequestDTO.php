<?php

declare(strict_types=1);

namespace User\Infrastructure\Adapter\REST\Symfony\Controller\Security\RegistrationController\DTO;

use Common\Infrastructure\Adapter\REST\Symfony\Request\RequestDTO;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Validator\Constraints as Assert;

class RegistrationRequestDTO implements RequestDTO, PasswordAuthenticatedUserInterface
{
    #[Assert\NotBlank(message: "Username should not be blank.")]
    #[Assert\Length(
        min: 4,
        max: 50,
        minMessage: "Username must be at least {{ limit }} characters long",
        maxMessage: "Username cannot be longer than {{ limit }} characters"
    )]
    public ?string $username;

    #[Assert\NotBlank(message: "Password should not be blank.")]
    #[Assert\Length(
        min: 8,
        max: 10,
        minMessage: "Password must be at least {{ limit }} characters long"
    )]
    public ?string $password;

    #[Assert\All([
        new Assert\NotBlank,
        new Assert\Choice(choices: ["ROLE_USER", "ROLE_ADMIN"], message: "Invalid role")
    ])]
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

    public function getPassword(): ?string
    {
        return $this->getPassword();
    }
}
