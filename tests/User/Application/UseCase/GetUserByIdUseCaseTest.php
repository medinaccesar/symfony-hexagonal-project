<?php

namespace App\Tests\User\Application\UseCase;

use PHPUnit\Framework\TestCase;
use User\Application\UseCase\GetUserById;
use User\Domain\Repository\UserRepositoryInterface;
use User\Domain\Model\User;

class GetUserByIdUseCaseTest extends TestCase
{
    public function testGetUserById(): void
    {
        $userRepository = $this->createMock(UserRepositoryInterface::class);
        $getUserByIdUseCase = new GetUserById($userRepository);
        $user = new User(1, 'example_username', 'example_password');

        $userRepository->method('findById')->willReturn($user);
        $resultUser = $getUserByIdUseCase->execute(1);

        $this->assertInstanceOf(User::class, $resultUser);
        $this->assertEquals(1, $resultUser->getId());
        $this->assertEquals('example_username', $resultUser->getUsername());
    }
}
