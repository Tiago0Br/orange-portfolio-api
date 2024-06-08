<?php

declare(strict_types=1);

namespace OrangePortfolio\Projects\Domain\Service;

use OrangePortfolio\Projects\Domain\Dto\DeleteProjectDto;
use OrangePortfolio\Projects\Domain\Exception\AnotherUsersProject;
use OrangePortfolio\Projects\Domain\Repository\ProjectRepositoryInterface;

class DeleteProject
{
    public function __construct(private readonly ProjectRepositoryInterface $projectRepository)
    {
    }

    public function delete(DeleteProjectDto $deleteProjectDto): void
    {
        $project = $this->projectRepository->getById($deleteProjectDto->projectId);
        if ($project->getUser()->getId() !== $deleteProjectDto->userId) {
            throw AnotherUsersProject::fromId($deleteProjectDto->userId);
        }

        $this->projectRepository->delete($project);
    }
}