<?php

namespace Common\Tests\User\Application\Command;


use Common\Domain\Exception\DuplicateValidationResourceException;
use Common\Domain\Service\Interface\UuidGeneratorServiceInterface;
use PHPUnit\Framework\TestCase;
use User\Application\Command\CreateUser\CreateUserCommand;
use User\Application\Command\CreateUser\CreateUserCommandHandler;
use User\Application\Command\CreateUser\CreateUser;
use User\Domain\Model\User;
use User\Infrastructure\Adapter\Persistence\ORM\Doctrine\Repository\DoctrineUserRepository;


class CreateUserTest extends TestCase
{
    private DoctrineUserRepository $userRepository;
    private UuidGeneratorServiceInterface $uuidGenerator;
    private CreateUserCommandHandler $createUserHandler;

    protected function setUp(): void
    {
        $this->userRepository = $this->createMock(DoctrineUserRepository::class);
        $this->uuidGenerator = $this->createMock(UuidGeneratorServiceInterface::class);
        $this->createUserHandler = new CreateUserCommandHandler($this->userRepository, $this->uuidGenerator);
    }

    public function testHandleCreatesNewUserSuccessfully()
    {
        $command = new CreateUserCommand('username', 'password', ['ROLE_USER']);
        $uuid = 'some-uuid';
        $this->userRepository->method('findByUsername')->willReturn(null);
        $this->uuidGenerator->method('generateUuid')->willReturn($uuid);
        $response = ($this->createUserHandler)($command);
        $this->assertInstanceOf(CreateUser::class, $response);
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
