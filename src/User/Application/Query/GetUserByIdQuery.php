<?php

namespace App\User\Application\Query;

use Shared\Exception\ResourceNotFoundException;
use User\Domain\Model\User;
use User\Domain\Repository\UserRepositoryInterface;

readonly class GetUserByIdQuery
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

        return $user;
    }
}

