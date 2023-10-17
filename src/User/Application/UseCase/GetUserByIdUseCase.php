<?php

namespace User\Application\UseCase;

use User\Domain\Repository\UserRepositoryInterface;
use User\Domain\Model\User;


class GetUserByIdUseCase
{
    public function __construct(
        private UserRepositoryInterface $userRepository
    ) {
    }

    public function execute(int $userId): ?User
    {
        return $this->userRepository->findById($userId);
    }
}
