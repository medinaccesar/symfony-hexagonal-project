<?php

declare(strict_types=1);

namespace User\Application\Command\CreateUser;

use Common\Domain\Bus\Event\EventBusInterface;
use Common\Domain\Exception\DuplicateValidationResourceException;
use User\Domain\Model\User;
use User\Domain\Repository\UserRepositoryInterface;

/**
 * UserCreator is responsible for handling the user creation logic.
 * It checks for duplicate users and persists the new user to the repository.
 */
final readonly class UserCreator
{
    /**
     * Constructor for UserCreator.
     *
     * @param UserRepositoryInterface $userRepository repository for user persistence
     * @param EventBusInterface       $bus            event bus for domain events
     */
    public function __construct(
        private UserRepositoryInterface $userRepository,
        private EventBusInterface $bus
    ) {
    }

    /**
     * Creates a new user and saves it to the repository.
     *
     * @param string $id       unique identifier for the new user
     * @param string $username username for the new user
     * @param string $password password for the new user
     * @param array  $roles    roles assigned to the new user
     *
     * @return User the newly created user
     *
     * @throws DuplicateValidationResourceException if a user with the same username already exists
     */
    public function __invoke(string $id, string $username, string $password, array $roles): User
    {
        // Check if a user with the given username already exists.
        $existingUser = $this->userRepository->findByUsername($username);
        if (null !== $existingUser) {
            throw new DuplicateValidationResourceException();
        }

        // Create a new user and persist it to the repository.
        $user = User::create($id, $username, $password, $roles);
        $this->userRepository->save($user);

        // Publish any domain events that have occurred.
        $this->bus->publish(...$user->pullDomainEvents());

        return $user;
    }
}
