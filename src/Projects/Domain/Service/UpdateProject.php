<?php

declare(strict_types=1);

namespace OrangePortfolio\Projects\Domain\Service;

use OrangePortfolio\Projects\Domain\Dto\UpdateProjectDto;
use OrangePortfolio\Projects\Domain\Entity\Project;
use OrangePortfolio\Projects\Domain\Repository\ProjectRepositoryInterface;

class UpdateProject
{
    public function __construct(private readonly ProjectRepositoryInterface $projectRepository)
    {
    }

    public function update(UpdateProjectDto $updateProjectDto): Project
    {
        $project = $this->projectRepository->getById($updateProjectDto->id);
        $project->update($updateProjectDto);
        $this->projectRepository->store($project);

        return $project;
    }
}