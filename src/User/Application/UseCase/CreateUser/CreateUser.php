<?php

namespace User\Application\UseCase\CreateUser;
use User\Application\Response\UserResponse;
use User\Application\UseCase\CreateUser\DTO\CreateUserInputDTO;
use User\Domain\Repository\UserRepositoryInterface;
use User\Domain\Model\User;

class CreateUser
{
    private UserRepositoryInterface $userRepository;


    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function handle(CreateUserInputDTO $dto): array
    {
        $user = new User(null, $dto->username, $dto->password, $dto->roles);
        $this->userRepository->save($user);

        $userResponse = new UserResponse();
        return $userResponse($user);
    }
}
