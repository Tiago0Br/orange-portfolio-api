<?php

declare(strict_types=1);

namespace OrangePortfolio\Core\Domain\Repository;

use OrangePortfolio\Core\Domain\Entity\Image;

interface ImageRepositoryInterface
{
    public function getById(int $id): Image;
}