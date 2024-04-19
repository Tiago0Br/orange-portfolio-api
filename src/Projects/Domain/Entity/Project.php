<?php

declare(strict_types=1);

namespace OrangePortfolio\Projects\Domain\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use OrangePortfolio\Projects\Domain\Dto\CreateProjectDto;

#[ORM\Table(name: 'projects')]
#[ORM\Entity]
class Project
{
    #[ORM\Id]
    #[ORM\Column(name: 'id', type: Types::INTEGER)]
    #[ORM\GeneratedValue(strategy: 'AUTO')]
    private int $id;

    #[ORM\Column(name: 'title', type: Types::STRING)]
    private string $title;

    #[ORM\Column(name: 'description', type: Types::STRING)]
    private string $description;

    #[ORM\Column(name: 'link', type: Types::STRING)]
    private string $link;

    #[ORM\Column(name: 'image_id', type: Types::INTEGER)]
    #[ORM\JoinColumn(name: 'images', referencedColumnName: 'id')]
    private int $imageId;

    #[ORM\Column(name: 'user_id', type: Types::INTEGER)]
    #[ORM\JoinColumn(name: 'users', referencedColumnName: 'id')]
    private int $userId;

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'link' => $this->link,
            'image_id' => $this->imageId,
            'user_id' => $this->userId,
        ];
    }

    public static function create(CreateProjectDto $projectDto): self
    {
        $project = new self();

        $project->title = $projectDto->title;
        $project->description = $projectDto->description;
        $project->link = $projectDto->link;
        $project->imageId = $projectDto->imageId;
        $project->userId = $projectDto->userId;

        return $project;
    }
}