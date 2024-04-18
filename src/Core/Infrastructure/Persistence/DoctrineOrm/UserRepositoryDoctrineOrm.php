<?php

namespace OrangePortfolio\Core\Infrastructure\Persistence\DoctrineOrm;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;
use OrangePortfolio\Core\Domain\Entity\User;
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
}