<?php

namespace User\Domain\Repository;

use User\Domain\Model\User;


interface UserRepositoryInterface
{
    public function findById(int $id): ?User;

    public function findByUsername(string $username): ?User;

    public function save(User $user): void;

    public function delete(User $user): void;

    public function findAll(): array;
}
