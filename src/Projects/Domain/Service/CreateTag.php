<?php

declare(strict_types=1);

namespace OrangePortfolio\Projects\Domain\Service;

use OrangePortfolio\Projects\Domain\Entity\Tag;
use OrangePortfolio\Projects\Domain\Exception\TagAlreadyExists;
use OrangePortfolio\Projects\Domain\Repository\TagRepositoryInterface;

class CreateTag
{
    public function __construct(private readonly TagRepositoryInterface $tagRepository)
    {
    }

    public function save(string $name): Tag
    {
        $sameTag = $this->tagRepository->exists($name);
        if (! $sameTag instanceof Tag) {
            $tag = Tag::create($name);
            $this->tagRepository->store($tag);

            return $tag;
        }

        throw TagAlreadyExists::fromName($name);
    }
}