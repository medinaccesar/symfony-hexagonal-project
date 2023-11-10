<?php

namespace User\Application\Query\GetUserById;

use Common\Domain\Exception\ResourceNotFoundException;
use User\Domain\Model\User;
use User\Domain\Repository\UserRepositoryInterface;

readonly class GetUserByIdHandler
{
    public function __construct(private UserRepositoryInterface $userRepository)
    {
    }

    public function __invoke(GetUserByIdQuery $query): GetUserByIdResponse
    {
        $user = $this->userRepository->findById($query->userId);
        if ($user === null) {
            Throw ResourceNotFoundException::createFromClassAndId(User::class, $query->userId);
        }
        return new GetUserByIdResponse($user->getId(), $user->getUsername(), $user->getRoles());
    }
}
