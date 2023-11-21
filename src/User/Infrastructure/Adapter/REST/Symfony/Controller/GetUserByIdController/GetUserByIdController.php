<?php

declare(strict_types=1);

namespace User\Infrastructure\Adapter\REST\Symfony\Controller\GetUserByIdController;

use Common\Domain\Exception\ResourceNotFoundException;
use Common\Infrastructure\Adapter\REST\Symfony\Response\Formatter\JsonApiResponse;
use Symfony\Component\Routing\Annotation\Route;
use User\Application\Query\GetUserById\GetUserByIdFinder;
use User\Application\Query\GetUserById\GetUserByIdQuery;

readonly class GetUserByIdController
{
    public function __construct(
        private GetUserByIdFinder $handler
    )
    {
    }

    /**
     * @throws ResourceNotFoundException
     */
    #[Route('/api/user/get/{id}', name: 'get_user_by_id', methods: ['GET'])]
    public function __invoke($id): JsonApiResponse
    {
        $query = new GetUserByIdQuery($id);
        $responseDTO = ($this->handler)($query);

        return JsonApiResponse::get($responseDTO);
    }
}
