<?php

declare(strict_types=1);

namespace User\Infrastructure\Adapter\REST\Controller\CreateUserController;

use Common\Infrastructure\Adapter\REST\Response\Formatter\JsonApiResponse;
use User\Infrastructure\Adapter\REST\Controller\CreateUserController\DTO\CreateUserRequestDTO;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


readonly class CreateUserController
{
    public function __construct(
    )
    {
    }

    #[Route('/create', name: 'create_user', methods: ['POST'])]
    public function __invoke(CreateUserRequestDTO $requestDTO): Response
    {
        return new JsonApiResponse();
    }
}
