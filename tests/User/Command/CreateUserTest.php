<?php

namespace Tests\User\Command;

use Common\Domain\Bus\Event\EventBusInterface;
use Common\Domain\Exception\DuplicateValidationResourceException;
use Common\Domain\ValueObject\Uuid;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use User\Application\Command\CreateUser\CreateUserCommand;
use User\Application\Command\CreateUser\CreateUserCommandHandler;
use User\Application\Command\CreateUser\CreateUserResponse;
use User\Application\Command\CreateUser\UserCreator;
use User\Domain\Event\CreateUserDomainEvent;
use User\Domain\Model\User;
use User\Infrastructure\Adapter\Persistence\ORM\Doctrine\Repository\DoctrineUserRepository;

class CreateUserTest extends TestCase
{
    /** @var DoctrineUserRepository&MockObject */
    private DoctrineUserRepository $userRepository;
    private CreateUserCommandHandler $createUserHandler;

    /** @var EventBusInterface&MockObject */
    private EventBusInterface $eventBus;

    protected function setUp(): void
    {
        $this->userRepository = $this->createMock(DoctrineUserRepository::class);
        $this->eventBus = $this->createMock(EventBusInterface::class);
        $this->createUserHandler = new CreateUserCommandHandler(
            new UserCreator($this->userRepository, $this->eventBus)
        );
    }

    /**
     * @throws DuplicateValidationResourceException
     */
    public function testHandleCreatesNewUserSuccessfully()
    {
        $command = new CreateUserCommand('username', 'password', ['ROLE_USER']);
        $this->userRepository->expects($this->once())
            ->method('findByUsername')
            ->with('username')
            ->willReturn(null);

        $this->userRepository->expects($this->once())
            ->method('save')
            ->with($this->isInstanceOf(User::class));

        $this->eventBus->expects($this->once())
            ->method('publish')
            ->with($this->isInstanceOf(CreateUserDomainEvent::class));

        $response = ($this->createUserHandler)($command);

        $this->assertInstanceOf(CreateUserResponse::class, $response);
        $this->assertTrue(Uuid::validateUuid($response->id));
    }

    public function testHandleThrowsExceptionForDuplicateUser()
    {
        $command = new CreateUserCommand('username', 'password', ['ROLE_USER']);
        $existingUser = new User('existing-uuid', 'username', 'password', ['ROLE_USER']);

        $this->userRepository->expects($this->once())
            ->method('findByUsername')
            ->with('username')
            ->willReturn($existingUser);

        $this->expectException(DuplicateValidationResourceException::class);
        $this->expectExceptionMessage('duplicate');

        ($this->createUserHandler)($command);
    }
}
