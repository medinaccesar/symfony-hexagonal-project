<?php

declare(strict_types=1);

namespace User\Infrastructure\Adapter\REST\Symfony\Controller\CreateUserController;

use User\Application\Command\CreateUser\CreateUserCommand;
use User\Application\Command\CreateUser\CreateUserHandler;
use Common\Infrastructure\Adapter\REST\Symfony\Response\Formatter\JsonApiResponse;
use User\Infrastructure\Adapter\REST\Symfony\Controller\CreateUserController\DTO\CreateUserRequestDTO;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


readonly class CreateUserController
{

    public function __construct(
        private CreateUserHandler $handler
    )
    {
    }

    #[Route('/create', name: 'create_user', methods: ['POST'])]
    public function __invoke(CreateUserRequestDTO $requestDTO): Response
    {
        $createUserCommand = new CreateUserCommand(
            $requestDTO->username,
            $requestDTO->password,
            $requestDTO->roles
        );

        $response = $this->handler->handle($createUserCommand);
        return new JsonApiResponse($response);
    }
}
