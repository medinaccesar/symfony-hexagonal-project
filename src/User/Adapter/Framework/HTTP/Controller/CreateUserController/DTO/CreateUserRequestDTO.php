<?php

namespace User\Adapter\Framework\HTTP\Controller\CreateUserController\DTO;

use Api\Adapter\Framework\HTTP\Controller\DTO\RequestDTO;
use Symfony\Component\HttpFoundation\Request;

class CreateUserRequestDTO implements RequestDTO
{
    public ?string $username;
    public ?string $password;
    public ?array  $roles;

    public function __construct(Request $request)
    {
        $this->username = $request->request->get('username');
        $this->username = $request->request->get('password');
        $this->roles = $request->request->get('roles');
    }
}