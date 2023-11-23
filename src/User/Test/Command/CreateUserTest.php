<?php

namespace User\Test\Command;


use Common\Domain\Bus\Event\EventBusInterface;
use Common\Domain\Exception\DuplicateValidationResourceException;
use Common\Domain\Service\Interface\UuidGeneratorServiceInterface;
use Common\Domain\ValueObject\Uuid;
use PHPUnit\Framework\TestCase;
use User\Application\Command\CreateUser\CreateUser;
use User\Application\Command\CreateUser\CreateUserCommand;
use User\Application\Command\CreateUser\CreateUserCommandHandler;
use User\Application\Command\CreateUser\UserCreator;
use User\Domain\Model\User;
use User\Infrastructure\Adapter\Persistence\ORM\Doctrine\Repository\DoctrineUserRepository;


class CreateUserTest extends TestCase
{
    private DoctrineUserRepository $userRepository;
    private CreateUserCommandHandler $createUserHandler;

    protected function setUp(): void
    {
        $this->userRepository = $this->createMock(DoctrineUserRepository::class);
        $this->createUserHandler = new CreateUserCommandHandler(
            new UserCreator(
                $this->userRepository,
                $this->createMock(EventBusInterface::class)
            ));
    }

    /**
     * @throws DuplicateValidationResourceException
     */
    public function testHandleCreatesNewUserSuccessfully()
    {
        $command = new CreateUserCommand('username', 'password', ['ROLE_USER']);
        $uuid = Uuid::generateUuid();
        $this->userRepository->method('findByUsername')->willReturn(null);
        $response = ($this->createUserHandler)($command);
        $this->assertInstanceOf(UserCreator::class, $response);
        $this->assertEquals($uuid, $response->userId);
    }

    public function testHandleThrowsExceptionForDuplicateUser()
    {
        $command = new CreateUserCommand('username', 'password', ['ROLE_USER']);
        $existingUser = new User('existing-uuid', 'username', 'password', ['ROLE_USER']);
        $this->userRepository->method('findByUsername')->willReturn($existingUser);
        $this->expectException(DuplicateValidationResourceException::class);
        ($this->createUserHandler)($command);
    }
}
