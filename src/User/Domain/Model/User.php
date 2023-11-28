<?php

declare(strict_types=1);

namespace User\Domain\Model;

use Common\Domain\Aggregate\AggregateRoot;
use User\Domain\Event\CreateUserDomainEvent;

class User extends AggregateRoot
{
    public function __construct(
        private readonly string $id,
        private string $username,
        private string $password,
        private readonly array $roles
    ) {
    }

    public static function create(string $id, string $username, string $password, array $roles): self
    {
        $user = new self($id, $username, $password, $roles);
        $user->record(new CreateUserDomainEvent($id, $username));

        return $user;
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function setUsername(string $username): static
    {
        $this->username = $username;

        return $this;
    }

    public function getRoles(): array
    {
        return $this->roles;
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
