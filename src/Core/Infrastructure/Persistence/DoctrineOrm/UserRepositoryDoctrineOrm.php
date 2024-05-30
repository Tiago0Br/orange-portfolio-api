<?php

namespace OrangePortfolio\Core\Infrastructure\Persistence\DoctrineOrm;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;
use OrangePortfolio\Core\Domain\Entity\User;
use OrangePortfolio\Core\Domain\Exception\UserNotFound;
use OrangePortfolio\Core\Domain\Repository\UserRepositoryInterface;

class UserRepositoryDoctrineOrm implements UserRepositoryInterface
{
    public function __construct(private readonly EntityManager $entityManager)
    {
    }

    public function store(User $user): void
    {
        try {
            $this->entityManager->persist($user);
            $this->entityManager->flush();
        } catch (OptimisticLockException | ORMException $e) {
            echo $e->getMessage();
        }
    }

    public function getByEmail(string $email): ?User
    {
        return $this->entityManager->getRepository(User::class)->findOneBy(['email' => $email]);
    }

    public function getById(int $id): User
    {
        $user = $this->entityManager->find(User::class, $id);
        if ($user instanceof User) {
            return $user;
        }

        throw UserNotFound::fromId($id);
    }
}