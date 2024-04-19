<?php

namespace OrangePortfolio\Projects\Domain\Repository;

use OrangePortfolio\Projects\Domain\Entity\Project;

interface ProjectRepositoryInterface
{
    public function store(Project $project): void;
}