<?php

declare(strict_types=1);

namespace User\Application\Command\CreateUser;

use Common\Domain\Bus\Command\CommandHandlerInterface;
use Common\Domain\Exception\DuplicateValidationResourceException;
use Common\Domain\ValueObject\Uuid;

/**
 * CreateUserCommandHandler handles the creation of new users.
 * Implements CommandHandlerInterface to integrate with command bus.
 */
final readonly class CreateUserCommandHandler implements CommandHandlerInterface
{
    /**
     * Constructor for CreateUserCommandHandler.
     *
     * @param UserCreator $creator the service responsible for creating new users
     */
    public function __construct(
        private UserCreator $creator
    ) {
    }

    /**
     * Invokes the command handler to process the CreateUserCommand.
     *
     * @param CreateUserCommand $command the command containing user creation data
     *
     * @return CreateUserResponse the response containing the ID of the created user
     *
     * @throws DuplicateValidationResourceException if a user with the same identifier already exists
     */
    public function __invoke(CreateUserCommand $command): CreateUserResponse
    {
        // Create a new user with the provided details.
        $user = $this->creator->__invoke(
            Uuid::generateUuid(),
            $command->getUsername(),
            $command->getPassword(),
            $command->getRoles() ?? []
        );

        // Return the response containing the new user's ID (Uuid).
        return new CreateUserResponse($user->getId());
    }
}
