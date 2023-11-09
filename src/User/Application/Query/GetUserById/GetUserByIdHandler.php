<?php

namespace User\Application\Query\GetUserById;

use RuntimeException;
use User\Application\Query\GetUserById\GetUserByIdQuery;
use User\Domain\Repository\UserRepositoryInterface;

readonly class GetUserByIdHandler
{
    public function __construct(private UserRepositoryInterface $userRepository) {}

    public function __invoke(GetUserByIdQuery $query): GetUserByIdResponse
    {
        $user = $this->userRepository->findById($query->userId);

        if ($user === null) {
            throw new RuntimeException('User not found');
        }

        return new GetUserByIdResponse($user->getId(), $user->getUsername(), $user->getRoles());
    }
}
