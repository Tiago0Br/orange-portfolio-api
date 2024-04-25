<?php

declare(strict_types=1);

namespace OrangePortfolio\Projects\Domain\Repository;

use OrangePortfolio\Projects\Domain\Entity\Project;

interface ProjectRepositoryInterface
{
    public function store(Project $project): void;

    public function getById(int $id): Project;

    public function delete(Project $project): void;
}