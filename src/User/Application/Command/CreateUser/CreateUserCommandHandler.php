<?php

declare(strict_types=1);

namespace User\Application\Command\CreateUser;

use Common\Domain\Bus\Command\CommandHandlerInterface;
use Common\Domain\ValueObject\Uuid;

final readonly class CreateUserCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private UserCreator $creator
    )
    {
    }

    public function __invoke(CreateUserCommand $command): CreateUserResponse
    {
        $user = $this->creator->__invoke(Uuid::generateUuid(), $command->getUsername(), $command->getPassword(), $command->getRoles());
        return new CreateUserResponse($user->getId());
    }
}