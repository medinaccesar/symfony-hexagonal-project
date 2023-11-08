<?php

declare(strict_types=1);

namespace User\Adapter\Framework\HTTP\Controller\CreateUserController;

use Api\Adapter\Framework\Service\Response\JsonApiResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use User\Adapter\Framework\HTTP\Controller\CreateUserController\DTO\CreateUserRequestDTO;
use User\Application\Command\CreateUser\CreateUserCommand;
use User\Application\Command\CreateUser\DTO\CreateUserInputDTO;


readonly class CreateUserController
{
    public function __construct(
        private CreateUserCommand $command
    )
    {
    }

    #[Route('/create', name: 'create_user', methods: ['POST'])]
    public function __invoke(CreateUserRequestDTO $requestDTO): Response
    {
        $response = $this->command->handle(
            CreateUserInputDTO::create($requestDTO->username, $requestDTO->password, $requestDTO->roles)
        );
        return new JsonApiResponse($response);
    }
}
