<?php

namespace App\Tests\User\Application\Query;

use User\Application\Query\GetUserById\DTO\GetUserByIdInputDTO;
use User\Application\Query\GetUserById\DTO\GetUserByIdOutputDTO;
use User\Application\Query\GetUserById\GetUserByIdQuery;
use PHPUnit\Framework\TestCase;
use User\Domain\Model\User;
use User\Domain\Repository\UserRepositoryInterface;

class GetUserByIdTest extends TestCase
{
    public function testGetUserById(): void
    {
        $userRepository = $this->createMock(UserRepositoryInterface::class);
        $getUserById = new GetUserByIdQuery($userRepository);

        $user = new User(1, 'example_username', 'example_password');
        $getUserByIdDto = new GetUserByIdInputDTO($user->getId());

        $userRepository->method('findById')->willReturn($user);
        $resultUser = $getUserById->handle($getUserByIdDto);

        $this->assertInstanceOf(GetUserByIdOutputDTO::class, $resultUser);
        $this->assertEquals(1, $resultUser->id);
        $this->assertEquals('example_username', $resultUser->username);
    }
}
