<?php

declare(strict_types=1);

namespace User\Infrastructure\Adapter\REST\Symfony\Controller\GetUserByIdController;

use Common\Domain\Exception\ResourceNotFoundException;
use Common\Infrastructure\Adapter\REST\Symfony\Response\Formatter\JsonApiResponse;
use Symfony\Component\Routing\Annotation\Route;
use User\Application\Query\GetUserById\GetUserByIdFinder;
use User\Application\Query\GetUserById\GetUserByIdQuery;

/**
 * Handles the request to get a user by their ID.
 */
readonly class GetUserByIdController
{
    public function __construct(
        private GetUserByIdFinder $handler
    ) {
    }

    /**
     * Retrieves a user by their ID.
     *
     * @param string $id the Uuid of the user
     *
     * @return JsonApiResponse the response in JSON format
     *
     * @throws ResourceNotFoundException if the user is not found
     */
    #[Route('/api/user/get/{id}', name: 'get_user_by_id', methods: ['GET'])]
    public function __invoke(string $id): JsonApiResponse
    {
        $query = new GetUserByIdQuery($id);
        $responseDTO = ($this->handler)($query);

        return JsonApiResponse::get($responseDTO);
    }
}
