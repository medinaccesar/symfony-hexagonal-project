<?php

declare(strict_types=1);

namespace User\Infrastructure\Adapter\REST\Symfony\Controller\RegistrationController;

use User\Infrastructure\Adapter\REST\Symfony\Controller\RegistrationController\DTO\RegistrationRequestDTO;
use Common\Infrastructure\Adapter\REST\Symfony\Response\Formatter\JsonApiResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use User\Application\Command\CreateUser\CreateUserCommand;
use User\Application\Command\CreateUser\CreateUserHandler;
use User\Domain\Validation\UserValidator;


readonly class RegistrationController
{
    public function __construct(
        private CreateUserHandler           $handler,
        private UserValidator               $validator,
        private UserPasswordHasherInterface $passwordHasher
    )
    {
    }

    #[Route('/register', name: 'register_user', methods: ['POST'])]
    public function __invoke(RegistrationRequestDTO $requestDTO): JsonApiResponse
    {
        $this->validator->validateAndThrows($requestDTO);
        $password = $this->passwordHasher->hashPassword($requestDTO, $requestDTO->password);
        $createUserCommand = new CreateUserCommand($requestDTO->username, $password, $requestDTO->roles);
        $response = ($this->handler)($createUserCommand);

        return new JsonApiResponse($response, Response::HTTP_CREATED);
    }
}