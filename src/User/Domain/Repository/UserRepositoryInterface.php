<?php

declare(strict_types=1);

namespace User\Domain\Repository;

use User\Domain\Model\User;

/**
 * Interface for the user repository.
 *
 * Defines the standard operations to be performed on User entities.
 */
interface UserRepositoryInterface
{
    /**
     * Find a user by their ID.
     *
     * @param string $id the ID of the user
     *
     * @return User|null the User if found, null otherwise
     */
    public function findById(string $id): ?User;

    /**
     * Find a user by their username.
     *
     * @param string $username the username of the user
     *
     * @return User|null the User if found, null otherwise
     */
    public function findByUsername(string $username): ?User;

    /**
     * Save a User entity.
     *
     * @param User $user the User entity to save
     */
    public function save(User $user): void;

    /**
     * Delete a User entity.
     *
     * @param User $user the User entity to delete
     */
    public function delete(User $user): void;

    /**
     * Find all users.
     *
     * @return User[] an array of User entities
     */
    public function findAll(): array;
}
