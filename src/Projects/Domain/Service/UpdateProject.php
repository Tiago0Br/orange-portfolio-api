<?php

declare(strict_types=1);

namespace OrangePortfolio\Projects\Domain\Service;

use OrangePortfolio\Core\Domain\Repository\ImageRepositoryInterface;
use OrangePortfolio\Projects\Domain\Dto\UpdateProjectDto;
use OrangePortfolio\Projects\Domain\Entity\Project;
use OrangePortfolio\Projects\Domain\Repository\ProjectRepositoryInterface;
use OrangePortfolio\Projects\Domain\Repository\TagRepositoryInterface;

class UpdateProject
{
    public function __construct(
        private readonly ProjectRepositoryInterface $projectRepository,
        private readonly TagRepositoryInterface $tagRepository,
        private readonly ImageRepositoryInterface $imageRepository
    ) {
    }

    public function update(UpdateProjectDto $updateProjectDto): Project
    {
        $image = $this->imageRepository->getById($updateProjectDto->imageId);
        $project = $this->projectRepository->getById($updateProjectDto->id);
        $tags = [];

        foreach ($updateProjectDto->tags as $tagId) {
            $tags[] = $this->tagRepository->getById($tagId);
        }

        $project->addTags($tags);
        $project->update($updateProjectDto, $image);
        $this->projectRepository->store($project);

        return $project;
    }
}