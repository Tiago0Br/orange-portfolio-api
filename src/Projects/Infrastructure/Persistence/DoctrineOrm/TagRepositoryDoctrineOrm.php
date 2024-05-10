<?php

declare(strict_types=1);

namespace OrangePortfolio\Projects\Infrastructure\Persistence\DoctrineOrm;

use Doctrine\ORM\EntityManager;
use OrangePortfolio\Projects\Domain\Entity\Tag;
use OrangePortfolio\Projects\Domain\Repository\TagRepositoryInterface;

class TagRepositoryDoctrineOrm implements TagRepositoryInterface
{
    public function __construct(private readonly EntityManager $entityManager)
    {
    }


    public function store(Tag $tag): void
    {
        $this->entityManager->persist($tag);
        $this->entityManager->flush();
    }

    public function exists(string $name): Tag | null
    {
        return $this->entityManager->getRepository(Tag::class)->findOneBy(['name' => $name]);
    }

    public function getById(int $id): Tag
    {
        return $this->entityManager->getRepository(Tag::class)->find($id);
    }
}