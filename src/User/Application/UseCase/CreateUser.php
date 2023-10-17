<?php

namespace User\Application\UseCase;

use User\Domain\Repository\UserRepositoryInterface;
use User\Domain\Model\User;

class CreateUser
{
    private UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function execute(string $username, string $password, array $roles = ['ROLE_USER']): User
    {
        $user = new User(null, $username, $password, $roles);
        $this->userRepository->save($user);

        return $user;
    }
}
