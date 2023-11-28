<?php

declare(strict_types=1);

namespace User\Infrastructure\Adapter\REST\Symfony\Controller\RegistrationController;

use Common\Domain\Exception\DuplicateValidationResourceException;
use Common\Domain\Exception\ValidationException;
use Common\Infrastructure\Adapter\REST\Symfony\Response\Formatter\JsonApiResponse;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use User\Application\Command\CreateUser\CreateUserCommand;
use User\Application\Command\CreateUser\CreateUserCommandHandler;
use User\Domain\Validation\CreateUserValidator;
use User\Infrastructure\Adapter\REST\Symfony\Controller\RegistrationController\DTO\RegistrationRequestDTO;

readonly class RegistrationController
{
    public function __construct(
        private CreateUserCommandHandler $handler,
        private CreateUserValidator $validator,
        private UserPasswordHasherInterface $passwordHasher
    ) {
    }

    /**
     * @throws ValidationException|DuplicateValidationResourceException
     */
    #[Route('/register', name: 'register_user', methods: ['POST'])]
    public function __invoke(RegistrationRequestDTO $requestDTO): JsonApiResponse
    {
        $this->validator->validateAndThrows($requestDTO);

        $password = $this->passwordHasher->hashPassword($requestDTO, $requestDTO->password);
        $createUserCommand = new CreateUserCommand($requestDTO->username, $password, $requestDTO->roles);
        $response = ($this->handler)($createUserCommand);

        return JsonApiResponse::create($response);
    }
}
