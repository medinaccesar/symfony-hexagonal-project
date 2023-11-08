<?php

declare(strict_types=1);

namespace User\Adapter\Framework\HTTP\Controller\GetUserByIdController;

use Api\Adapter\Framework\Service\Response\JsonApiResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use User\Adapter\Framework\HTTP\Controller\GetUserByIdController\DTO\GetUserByIdRequestDTO;
use User\Application\Query\GetUserById\DTO\GetUserByIdInputDTO;
use User\Application\Query\GetUserById\GetUserByIdQuery;

class GetUserByIdController extends AbstractController
{
    public function __construct(
        private readonly GetUserByIdQuery $query
    )
    {
    }

    #[Route('/get/{id}', name: 'get_user_by_id', methods: ['GET'])]
    public function __invoke(GetUserByIdRequestDTO $requestDTO): JsonApiResponse
    {
        $outputDto = $this->query->handle(
            GetUserByIdInputDTO::create($requestDTO->id)
        );
        return new JsonApiResponse($outputDto);
    }
}
