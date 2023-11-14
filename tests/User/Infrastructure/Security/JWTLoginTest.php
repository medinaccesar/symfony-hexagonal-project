<?php

namespace Common\Tests\User\Infrastructure\Security;

use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;
use User\Domain\Model\User;
use User\Infrastructure\Adapter\Persistence\ORM\Doctrine\Repository\DoctrineUserRepository;

class JWTLoginTest extends WebTestCase
{
    private ?KernelBrowser $client = null;
    private DoctrineUserRepository $userRepository;

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->userRepository = $this->createMock(DoctrineUserRepository::class);
        $this->setUpTestUser();
    }

    private function setUpTestUser(): void
    {
        $testUsername = 'usernameTest';
        $testPassword = 'passwordTest';
        $testRoles = ['ROLE_USER'];

        $userMock = $this->createMock(User::class);
        $userMock->method('getUsername')->willReturn($testUsername);
        $userMock->method('getPassword')->willReturn($testPassword);
        $userMock->method('getRoles')->willReturn($testRoles);

        $this->userRepository->method('findByUsername')
            ->willReturnCallback(function ($username) use ($testUsername, $userMock) {
                if ($username === $testUsername) {
                    return $userMock;
                }
                return null;
            });
    }

    public function testSuccessfulLogin()
    {
        $this->client->request(
            'POST', '/login_check', [], [], ['CONTENT_TYPE' => 'application/json'], json_encode([
            'username' => 'usernameTest',
            'password' => 'passwordTest'
        ]));

        $this->assertResponseIsSuccessful();
        $response = $this->client->getResponse();
        $this->assertTrue($response->headers->contains('Content-Type', 'application/json'));

        $data = json_decode($response->getContent(), true);
        $this->assertArrayHasKey('token', $data);
    }

    public function testFailedLogin()
    {
        $this->client->request('POST', '/api/login_check', [], [], ['CONTENT_TYPE' => 'application/json'], json_encode([
            'username' => 'usernameTest',
            'password' => 'wrongPassword'
        ]));

        $response = $this->client->getResponse();
        $this->assertSame(Response::HTTP_UNAUTHORIZED, $response->getStatusCode());
    }
}
