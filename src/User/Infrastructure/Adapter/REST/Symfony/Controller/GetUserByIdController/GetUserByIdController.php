<?php

declare(strict_types=1);

namespace User\Infrastructure\Adapter\REST\Symfony\Controller\GetUserByIdController;

use Common\Infrastructure\Adapter\REST\Symfony\Response\Formatter\JsonApiResponse;
use Common\Infrastructure\Service\Symfony\Validation\ValidationService;
use User\Infrastructure\Adapter\REST\Symfony\Controller\GetUserByIdController\DTO\GetUserByIdRequestDTO;
use Symfony\Component\Routing\Annotation\Route;
use User\Application\Query\GetUserById\GetUserByIdHandler;
use User\Application\Query\GetUserById\GetUserByIdQuery;

readonly class GetUserByIdController
{
    public function __construct(private GetUserByIdHandler $handler)
    {
    }

    #[Route('/get/{id}', name: 'get_user_by_id', methods: ['GET'])]
    public function __invoke(GetUserByIdRequestDTO $requestDTO): JsonApiResponse
    {
        $query = new GetUserByIdQuery($requestDTO->id);
        $responseDTO = ($this->handler)($query);
        return new JsonApiResponse($responseDTO);
    }
}
