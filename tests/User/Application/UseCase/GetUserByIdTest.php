<?php

namespace App\Tests\User\Application\UseCase;

use User\Application\UseCase\GetUserById\GetUserByIdUseCase;
use PHPUnit\Framework\TestCase;
use User\Domain\Model\User;
use User\Domain\Repository\UserRepositoryInterface;

class GetUserByIdTest extends TestCase
{
    public function testGetUserById(): void
    {
        $userRepository = $this->createMock(UserRepositoryInterface::class);
        $getUserById = new GetUserByIdUseCase($userRepository);
        $user = new User(1, 'example_username', 'example_password');

        $userRepository->method('findById')->willReturn($user);
        $resultUser = $getUserById->handle(1);

        $this->assertInstanceOf(User::class, $resultUser);
        $this->assertEquals(1, $resultUser->getId());
        $this->assertEquals('example_username', $resultUser->getUsername());
    }
}
