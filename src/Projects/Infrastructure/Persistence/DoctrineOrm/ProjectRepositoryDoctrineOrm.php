<?php

declare(strict_types=1);

namespace OrangePortfolio\Projects\Infrastructure\Persistence\DoctrineOrm;

use Doctrine\ORM\EntityManager;
use OrangePortfolio\Projects\Domain\Dto\GetProjectsDto;
use OrangePortfolio\Projects\Domain\Entity\Project;
use OrangePortfolio\Projects\Domain\Exception\ProjectNotFoundException;
use OrangePortfolio\Projects\Domain\Repository\ProjectRepositoryInterface;

class ProjectRepositoryDoctrineOrm implements ProjectRepositoryInterface
{
    public function __construct(private readonly EntityManager $entityManager)
    {
    }

    public function store(Project $project): void
    {
        $this->entityManager->persist($project);
        $this->entityManager->flush();
    }

    public function getById(int $id): Project
    {
        $project = $this->entityManager->find(Project::class, $id);

        if ($project instanceof Project) {
            return $project;
        }

        throw ProjectNotFoundException::fromId($id);
    }

    public function delete(Project $project): void
    {
        $this->entityManager->remove($project);
        $this->entityManager->flush();
    }

    public function getAllByTags(GetProjectsDto $getProjectsDto): array
    {
        if (! $getProjectsDto->tags) {
            return $this->entityManager->getRepository(Project::class)->findAll();
        }

        $queryBuilder = $this->entityManager->createQueryBuilder();
        $queryBuilder
            ->select('project')
            ->from(Project::class, 'project')
            ->innerJoin('project.projectTag', 'projectTag')
            ->innerJoin('project.user', 'user')
            ->innerJoin('projectTag.tag', 'tag')
            ->where('tag.id IN (:TAGS)')
            ->setParameter('TAGS', $getProjectsDto->tags);

        $condition = $getProjectsDto->onlyMyProjects === 1 ? 'user.id = :USER_ID' : 'user.id != :USER_ID';

        $queryBuilder
            ->andWhere($condition)
            ->setParameter('USER_ID', $getProjectsDto->userId);

        return (array) $queryBuilder->getQuery()->getResult();
    }
}