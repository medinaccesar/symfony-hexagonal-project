<?php

declare(strict_types=1);

namespace User\Infrastructure\Adapter\REST\Controller\GetUserByIdController;

use Common\Infrastructure\Adapter\REST\Response\Formatter\JsonApiResponse;
use User\Infrastructure\Adapter\REST\Controller\GetUserByIdController\DTO\GetUserByIdRequestDTO;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use User\Application\Query\GetUserById\GetUserByIdHandler;
use User\Application\Query\GetUserById\GetUserByIdQuery;

class GetUserByIdController extends AbstractController
{
    public function __construct(
        private readonly GetUserByIdHandler $handler
    )
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
