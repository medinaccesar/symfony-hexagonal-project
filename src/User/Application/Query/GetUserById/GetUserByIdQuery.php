<?php

namespace User\Application\Query\GetUserById;

use Core\Exception\ResourceNotFoundException;
use User\Application\Query\GetUserById\DTO\GetUserByIdInputDTO;
use User\Application\Query\GetUserById\DTO\GetUserByIdOutputDTO;
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
    public function handle(GetUserByIdInputDTO $dto): GetUserByIdOutputDTO
    {
        $user = $this->userRepository->findById($dto->id);

        if (!$user) {
            throw ResourceNotFoundException::createFromClassAndId(User::class, $dto->id);
        }

        return GetUserByIdOutputDTO::create($user);
    }
}

