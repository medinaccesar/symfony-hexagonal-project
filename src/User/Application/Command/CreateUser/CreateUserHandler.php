<?php

namespace User\Application\Command\CreateUser;

use Common\Domain\Service\Interface\UuidGeneratorInterface;
use User\Domain\Model\User;
use User\Domain\Repository\UserRepositoryInterface;

readonly class CreateUserHandler
{
    public function __construct(
        private UserRepositoryInterface $userRepository,
        private UuidGeneratorInterface  $uuidGenerator
    )
    {
    }

    public function handle(CreateUserCommand $command): CreateUserResponse
    {
        $user = new User($this->uuidGenerator->generateUuid(), $command->username, $command->password, $command->roles);
        $this->userRepository->save($user);
        return new CreateUserResponse($user->getId());
    }
}