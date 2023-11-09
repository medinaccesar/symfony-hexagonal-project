<?php

declare(strict_types=1);

namespace User\Infrastructure\Adapter\REST\Symfony\Controller\CreateUserController;

use Common\Infrastructure\Service\Symfony\Validation\ValidationService;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use User\Application\Command\CreateUser\CreateUserCommand;
use User\Application\Command\CreateUser\CreateUserHandler;
use Common\Infrastructure\Adapter\REST\Symfony\Response\Formatter\JsonApiResponse;
use User\Infrastructure\Adapter\REST\Symfony\Controller\CreateUserController\DTO\CreateUserRequestDTO;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


readonly class CreateUserController
{

    public function __construct(
        private CreateUserHandler $handler,
        private ValidationService $validator
    )
    {
    }

    #[Route('/create', name: 'create_user', methods: ['POST'])]
    public function __invoke(CreateUserRequestDTO $requestDTO): JsonApiResponse
    {
        $violations = $this->validator->validate($requestDTO);
        if (count($violations) > 0) {
            $formattedViolations = $this->validator->formatViolations($violations);
            return new JsonApiResponse(['errors' => $formattedViolations], Response::HTTP_BAD_REQUEST);
        }

        $createUserCommand = new CreateUserCommand(
            $requestDTO->username,
            $requestDTO->password,
            $requestDTO->roles
        );

        $response = $this->handler->handle($createUserCommand);
        return new JsonApiResponse($response);
    }
}
