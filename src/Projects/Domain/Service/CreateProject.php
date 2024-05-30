<?php

declare(strict_types=1);

namespace OrangePortfolio\Projects\Domain\Service;

use OrangePortfolio\Core\Domain\Repository\ImageRepositoryInterface;
use OrangePortfolio\Core\Domain\Repository\UserRepositoryInterface;
use OrangePortfolio\Projects\Domain\Dto\CreateProjectDto;
use OrangePortfolio\Projects\Domain\Entity\Project;
use OrangePortfolio\Projects\Domain\Repository\ProjectRepositoryInterface;
use OrangePortfolio\Projects\Domain\Repository\TagRepositoryInterface;

class CreateProject
{
    public function __construct(
        private readonly ProjectRepositoryInterface $projectRepository,
        private readonly TagRepositoryInterface $tagRepository,
        private readonly UserRepositoryInterface $userRepository,
        private readonly ImageRepositoryInterface $imageRepository
    ) {
    }

    public function save(CreateProjectDto $projectDto): Project
    {
        $user = $this->userRepository->getById($projectDto->userId);
        $image = $this->imageRepository->getById($projectDto->imageId);
        $project = Project::create(
            projectDto: $projectDto,
            user: $user,
            image: $image
        );

        $tags = [];

        foreach ($projectDto->tags as $tagId) {
            $tags[] = $this->tagRepository->getById($tagId);
        }

        $project->addTags($tags);
        $this->projectRepository->store($project);

        return $project;
    }
}