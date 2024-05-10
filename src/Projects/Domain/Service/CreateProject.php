<?php

declare(strict_types=1);

namespace OrangePortfolio\Projects\Domain\Service;

use OrangePortfolio\Projects\Domain\Dto\CreateProjectDto;
use OrangePortfolio\Projects\Domain\Entity\Project;
use OrangePortfolio\Projects\Domain\Repository\ProjectRepositoryInterface;
use OrangePortfolio\Projects\Domain\Repository\TagRepositoryInterface;

class CreateProject
{
    public function __construct(
        private readonly ProjectRepositoryInterface $projectRepository,
        private readonly TagRepositoryInterface $tagRepository,
    ) {
    }

    public function save(CreateProjectDto $projectDto): Project
    {
        $project = Project::create($projectDto);
        $tags = [];

        foreach ($projectDto->tags as $tagId) {
            $tags[] = $this->tagRepository->getById($tagId);
        }

        $project->addTags($tags);
        $this->projectRepository->store($project);

        return $project;
    }
}