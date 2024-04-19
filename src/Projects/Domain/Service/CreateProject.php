<?php

namespace OrangePortfolio\Projects\Domain\Service;

use OrangePortfolio\Projects\Domain\Dto\CreateProjectDto;
use OrangePortfolio\Projects\Domain\Entity\Project;
use OrangePortfolio\Projects\Domain\Repository\ProjectRepositoryInterface;

class CreateProject
{
    public function __construct(private readonly ProjectRepositoryInterface $projectRepository)
    {
    }

    public function save(CreateProjectDto $projectDto): Project
    {
        $project = Project::create($projectDto);
        $this->projectRepository->store($project);

        return $project;
    }
}