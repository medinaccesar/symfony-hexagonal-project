<?php

declare(strict_types=1);

namespace User\Application\Command\CreateUser;

use Common\Domain\Bus\Event\EventBusInterface;
use Common\Domain\Exception\DuplicateValidationResourceException;
use User\Domain\Model\User;
use User\Domain\Repository\UserRepositoryInterface;

final readonly class UserCreator
{
    public function __construct(
        private UserRepositoryInterface $userRepository,
        private EventBusInterface       $bus
    )
    {
    }

    /**
     * @throws DuplicateValidationResourceException
     */
    public function __invoke($id, $username, $password, $roles): User
    {
        $existingUser = $this->userRepository->findByUsername($username);
        if ($existingUser !== null) {
            throw new DuplicateValidationResourceException();
        }
        $user = User::create($id, $username, $password, $roles);
        $this->userRepository->save($user);
        $this->bus->publish(...$user->pullDomainEvents());
        return $user;
    }

}