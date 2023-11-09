<?php

namespace User\Infrastructure\Adapter\Persistence\ORM\Doctrine\Repository;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use User\Domain\Model\User;
use User\Domain\Repository\UserRepositoryInterface;

class DoctrineUserRepository implements UserRepositoryInterface
{
    private EntityRepository $userRepository;
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->userRepository = $entityManager->getRepository(User::class);
    }

    public function findByUsername(string $username): ?User
    {
        return $this->userRepository->findOneBy(['username' => $username]);
    }

    public function findById(int $id): ?User
    {
        return $this->userRepository->find($id);
    }

    public function save(User $user): void
    {
        $this->entityManager->persist($user);
        $this->entityManager->flush();
    }

    public function delete(User $user): void
    {
        $this->entityManager->remove($user);
        $this->entityManager->flush();
    }

    public function findAll(): array
    {
        return $this->userRepository->findAll();
    }
}
