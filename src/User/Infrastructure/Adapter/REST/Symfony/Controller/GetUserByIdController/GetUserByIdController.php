<?php

declare(strict_types=1);

namespace User\Infrastructure\Adapter\REST\Symfony\Controller\GetUserByIdController;

use Common\Infrastructure\Adapter\REST\Symfony\Response\Formatter\JsonApiResponse;
use User\Infrastructure\Adapter\REST\Symfony\Controller\GetUserByIdController\DTO\GetUserByIdRequestDTO;
use Symfony\Component\Routing\Annotation\Route;
use User\Application\Query\GetUserById\GetUserByIdHandler;
use User\Application\Query\GetUserById\GetUserByIdQuery;

readonly class GetUserByIdController
{
    public function __construct(
        private GetUserByIdHandler $handler
    )
    {
    }

    #[Route('/api/user/get/{id}', name: 'get_user_by_id', methods: ['GET'])]
    public function __invoke($id): JsonApiResponse
    {
        $query = new GetUserByIdQuery($id);
        $responseDTO = ($this->handler)($query);
        return new JsonApiResponse($responseDTO);
    }
}
