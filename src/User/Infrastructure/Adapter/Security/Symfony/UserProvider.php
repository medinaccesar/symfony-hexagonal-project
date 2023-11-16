<?php

namespace User\Infrastructure\Adapter\Security\Symfony;

use Common\Domain\Exception\ResourceNotFoundException;
use Common\Domain\Exception\ValidationException;
use Common\Domain\Validation\Trait\NotBlankValidationTrait;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use User\Domain\Model\User;
use User\Infrastructure\Adapter\Persistence\ORM\Doctrine\Repository\DoctrineUserRepository;

readonly class UserProvider implements UserProviderInterface
{
    use NotBlankValidationTrait;

    public function __construct(
        private DoctrineUserRepository $userRepository
    )
    {
    }

    public function loadUserByUsername($username): UserInterface
    {
        if ($violation = $this->validateNotBlank($username, 'username')) {
            throw ValidationException::createFromViolations($violation);
        }
        $user = $this->userRepository->findByUsername($username);
        if (null === $user) {
            throw ResourceNotFoundException::createFromClassAndId(User::class, $username);
        }

        return new UserAdapter($user);
    }


    public function refreshUser(UserInterface $user): UserInterface
    {
        if (!$user instanceof UserAdapter) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', get_class($user)));
        }

        $username = $user->getUsername();
        return $this->loadUserByUsername($username);
    }

    public function supportsClass(string $class): bool
    {
        return UserAdapter::class === $class;
    }

    public function loadUserByIdentifier(string $identifier): UserInterface
    {
        return $this->loadUserByUsername($identifier);
    }
}