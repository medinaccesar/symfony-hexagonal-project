<?php

declare(strict_types=1);

namespace User\Infrastructure\Adapter\Security\Symfony;

use Common\Domain\Exception\Constant\ExceptionMessage;
use Common\Domain\Exception\ResourceNotFoundException;
use Common\Domain\Exception\ValidationException;
use Common\Domain\Validation\Trait\NotBlankValidationTrait;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use User\Infrastructure\Adapter\Persistence\ORM\Doctrine\Repository\DoctrineUserRepository;

readonly class UserProvider implements UserProviderInterface
{
    use NotBlankValidationTrait;

    public function __construct(
        private DoctrineUserRepository $userRepository
    ) {
    }

    /**
     * @throws ResourceNotFoundException
     * @throws ValidationException
     */
    public function loadUserByUsername($username): UserInterface
    {
        if ($violation = $this->validateNotBlank($username, 'username')) {
            throw new ValidationException($violation);
        }
        $user = $this->userRepository->findByUsername($username);
        if (null === $user) {
            throw new ResourceNotFoundException();
        }

        return new UserAdapter($user);
    }

    /**
     * @throws ResourceNotFoundException
     * @throws ValidationException
     */
    public function refreshUser(UserInterface $user): UserInterface
    {
        if (!$user instanceof UserAdapter) {
            throw new UnsupportedUserException(ExceptionMessage::NOT_SUPPORTED);
        }

        $username = $user->getUserIdentifier();

        return $this->loadUserByUsername($username);
    }

    public function supportsClass(string $class): bool
    {
        return UserAdapter::class === $class;
    }

    /**
     * @throws ResourceNotFoundException
     * @throws ValidationException
     */
    public function loadUserByIdentifier(string $identifier): UserInterface
    {
        return $this->loadUserByUsername($identifier);
    }
}
