<?php

declare(strict_types=1);

namespace OrangePortfolio\Projects\Domain\Repository;

use OrangePortfolio\Projects\Domain\Entity\Tag;

interface TagRepositoryInterface
{
    public function store(Tag $tag): void;

    public function exists(string $name): Tag | null;

    public function getById(int $id): Tag;
}