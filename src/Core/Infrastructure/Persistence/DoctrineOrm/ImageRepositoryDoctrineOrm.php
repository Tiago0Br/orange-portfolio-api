<?php

declare(strict_types=1);

namespace OrangePortfolio\Core\Infrastructure\Persistence\DoctrineOrm;

use Doctrine\ORM\EntityManager;
use OrangePortfolio\Core\Domain\Entity\Image;
use OrangePortfolio\Core\Domain\Exception\ImageNotFound;
use OrangePortfolio\Core\Domain\Repository\ImageRepositoryInterface;

class ImageRepositoryDoctrineOrm implements ImageRepositoryInterface
{
    public function __construct(private readonly EntityManager $entityManager)
    {
    }

    public function getById(int $id): Image
    {
        $image = $this->entityManager->find(Image::class, $id);
        if ($image instanceof Image) {
            return $image;
        }

        throw ImageNotFound::fromId($id);
    }
}