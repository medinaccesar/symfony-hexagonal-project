<?php

declare(strict_types=1);

namespace User\Application\Query\GetUserById;

use Common\Domain\Exception\ResourceNotFoundException;
use User\Domain\Model\User;
use User\Domain\Repository\UserRepositoryInterface;

readonly class GetUserByIdFinder
{
    public function __construct(
        private UserRepositoryInterface $userRepository
    )
    {
    }

    /**
     * @throws ResourceNotFoundException
     */
    public function __invoke(GetUserByIdQuery $query): GetUserByIdResponse
    {
        $user = $this->userRepository->findById($query->userId);
        if ($user === null) {
            throw new ResourceNotFoundException();
        }
        return new GetUserByIdResponse($user->getId(), $user->getUsername(), $user->getRoles());
    }
}
