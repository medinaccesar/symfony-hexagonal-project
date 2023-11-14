<?php

namespace User\Application\Command\CreateUser;

use Common\Domain\Service\Interface\UuidGeneratorServiceInterface;
use Common\Domain\Exception\DuplicateResourceException;
use User\Domain\Model\User;
use User\Domain\Repository\UserRepositoryInterface;

readonly class CreateUserHandler
{
    public function __construct(
        private UserRepositoryInterface       $userRepository,
        private UuidGeneratorServiceInterface $uuidGenerator
    )
    {
    }

    public function handle(CreateUserCommand $command): CreateUserResponse
    {
        $existingUser = $this->userRepository->findByUsername($command->username);
        if ($existingUser !== null) {
            throw DuplicateResourceException::createFromValue($command->username);
        }
        $uuid = $this->uuidGenerator->generateUuid();

        $user = new User($uuid, $command->username, $command->password, $command->roles);
        $this->userRepository->save($user);
        return new CreateUserResponse($uuid);
    }
}