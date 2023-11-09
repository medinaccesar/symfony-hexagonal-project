<?php

namespace Common\Tests\User\Application\Query;

use User\Application\Query\GetUserById\GetUserByIdResponse;
use PHPUnit\Framework\TestCase;
use User\Application\Query\GetUserById\DTO\GetUserByIdHandler;
use User\Application\Query\GetUserById\GetUserByIdQuery;
use User\Domain\Model\User;
use User\Domain\Repository\UserRepositoryInterface;

class GetUserByIdTest extends TestCase
{
    public function testGetUserById(): void
    {
        $userRepository = $this->createMock(UserRepositoryInterface::class);
        $getUserById = new GetUserByIdQuery($userRepository);

        $user = new User(1, 'example_username', 'example_password');
        $getUserByIdDto = new GetUserByIdHandler($user->getId());

        $userRepository->method('findById')->willReturn($user);
        $resultUser = $getUserById->handle($getUserByIdDto);

        $this->assertInstanceOf(GetUserByIdResponse::class, $resultUser);
        $this->assertEquals(1, $resultUser->id);
        $this->assertEquals('example_username', $resultUser->username);
    }
}
