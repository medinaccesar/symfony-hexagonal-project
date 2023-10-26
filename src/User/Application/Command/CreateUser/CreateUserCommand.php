<?php

namespace User\Application\Command\CreateUser;
use User\Application\Command\CreateUser\DTO\CreateUserInputDTO;
use User\Domain\Model\User;
use User\Domain\Repository\UserRepositoryInterface;

class CreateUserCommand
{
    private UserRepositoryInterface $userRepository;


    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function handle(CreateUserInputDTO $dto): User
    {
        $user = new User(null, $dto->username, $dto->password, $dto->roles);
        $this->userRepository->save($user);

        return $user;
    }
}
