<?php

declare(strict_types=1);

namespace OrangePortfolio\Projects\Domain\Service;

use OrangePortfolio\Projects\Domain\Repository\ProjectRepositoryInterface;

class DeleteProject
{
    public function __construct(private readonly ProjectRepositoryInterface $projectRepository)
    {
    }

    public function delete(int $id): void
    {
        $project = $this->projectRepository->getById($id);
        $this->projectRepository->delete($project);
    }
}