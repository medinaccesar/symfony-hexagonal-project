<?php

declare(strict_types=1);

namespace User\Application\Query\GetUserById;

use Common\Domain\Bus\Query\QueryFinderInterface;
use Common\Domain\Exception\ResourceNotFoundException;
use User\Domain\Repository\UserRepositoryInterface;

/**
 * Class GetUserByIdFinder.
 *
 * This class is responsible for handling the 'get user by ID' query, retrieving
 * user information based on their ID.
 */
final readonly class GetUserByIdFinder implements QueryFinderInterface
{
    /**
     * Constructor with UserRepositoryInterface injection.
     *
     * @param UserRepositoryInterface $userRepository user repository interface
     */
    public function __construct(
        private UserRepositoryInterface $userRepository
    ) {
    }

    /**
     * Handles the 'get user by ID' query.
     *
     * @param GetUserByIdQuery $query the query object containing the user ID
     *
     * @return GetUserByIdResponse the response object with user details
     *
     * @throws ResourceNotFoundException thrown when the user is not found
     */
    public function __invoke(GetUserByIdQuery $query): GetUserByIdResponse
    {
        $user = $this->userRepository->findById($query->userId);

        if (null === $user) {
            throw new ResourceNotFoundException();
        }

        return new GetUserByIdResponse(
            id: $user->getId(),
            username: $user->getUsername(),
            roles: $user->getRoles()
        );
    }
}
