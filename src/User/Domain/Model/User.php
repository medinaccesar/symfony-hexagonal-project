<?php

namespace User\Domain\Model;


class User
{
    public function __construct(
        private readonly string $id,
        private string          $username,
        private string          $password,
        private ?array          $roles
    )
    {
        if ($this->roles === null) {
            $this->roles = ['ROLE_USER'];
        }
    }


    public function getId(): ?string
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): static
    {
        $this->username = $username;
        return $this;
    }

    public function getUserIdentifier(): string
    {
        return (string)$this->getUsername();
    }

    public function getRoles(): array
    {
        $roles = $this->roles;
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): static
    {
        $this->roles = $roles;
        return $this;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;
        return $this;
    }
}
