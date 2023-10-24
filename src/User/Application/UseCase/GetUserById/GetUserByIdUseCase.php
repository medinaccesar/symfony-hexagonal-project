<?php

namespace User\Application\UseCase\GetUserById;

use Shared\Exception\ResourceNotFoundException;
use User\Application\Response\UserResponse;
use User\Domain\Model\User;
use User\Domain\Repository\UserRepositoryInterface;

readonly class GetUserByIdUseCase
{
    public function __construct(
        private UserRepositoryInterface $userRepository
    )
    {
    }

    /**
     * @throws ResourceNotFoundException
     */
    public function handle($id): array
    {
        $user = $this->userRepository->findById($id);

        if (!$user) {
            throw ResourceNotFoundException::createFromClassAndId(User::class, $id);
        }

        return (new UserResponse())($user);
    }
}

