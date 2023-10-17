<?php

namespace App\Tests\User\Application\UseCase;

use PHPUnit\Framework\TestCase;
use User\Application\UseCase\GetUserByIdUseCase;
use User\Domain\Repository\UserRepositoryInterface;
use User\Domain\Model\User;

class GetUserByIdUseCaseTest extends TestCase
{
    public function testGetUserById(): void
    {
        // Mock UserRepositoryInterface
        $userRepository = $this->createMock(UserRepositoryInterface::class);

        // Crea una instancia de GetUserByIdUseCase con el repositorio simulado
        $getUserByIdUseCase = new GetUserByIdUseCase($userRepository);

        // Define un usuario de ejemplo para las pruebas
        $user = new User('example_username', 'example_password');
        $user->setId(1);

        // Configura el UserRepositoryInterface simulado para que devuelva el usuario de ejemplo
        $userRepository->method('findById')
            ->willReturn($user);

        // Llama al método execute del caso de uso para obtener un usuario por ID
        $resultUser = $getUserByIdUseCase->execute(1);

        // Realiza aserciones para verificar si el usuario devuelto coincide con el usuario de ejemplo
        $this->assertInstanceOf(User::class, $resultUser);
        $this->assertEquals(1, $resultUser->getId());
        $this->assertEquals('example_username', $resultUser->getUsername());
    }
}
