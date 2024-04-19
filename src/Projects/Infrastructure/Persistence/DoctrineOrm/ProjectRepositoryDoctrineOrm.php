<?php

declare(strict_types=1);

namespace OrangePortfolio\Projects\Infrastructure\Persistence\DoctrineOrm;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;
use OrangePortfolio\Projects\Domain\Entity\Project;
use OrangePortfolio\Projects\Domain\Repository\ProjectRepositoryInterface;

class ProjectRepositoryDoctrineOrm implements ProjectRepositoryInterface
{
    public function __construct(private readonly EntityManager $entityManager)
    {
    }

    public function store(Project $project): void
    {
        try {
            $this->entityManager->persist($project);
            $this->entityManager->flush();
        } catch (ORMException | OptimisticLockException $e) {
            echo $e->getMessage();
        }
    }
}