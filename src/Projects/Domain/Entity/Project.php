<?php

declare(strict_types=1);

namespace OrangePortfolio\Projects\Domain\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use OrangePortfolio\Core\Domain\Entity\Image;
use OrangePortfolio\Core\Domain\Entity\User;
use OrangePortfolio\Projects\Domain\Dto\CreateProjectDto;
use OrangePortfolio\Projects\Domain\Dto\UpdateProjectDto;

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

    #[ORM\OneToOne(targetEntity: Image::class, cascade: ['persist'])]
    #[ORM\JoinColumn(name: 'image_id', referencedColumnName: 'id', onDelete: 'CASCADE')]
    private Image $image;

    #[ORM\OneToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(name: 'user_id', referencedColumnName: 'id')]
    private User $user;

    #[ORM\OneToMany(
        targetEntity: ProjectTag::class,
        mappedBy: 'project',
        cascade: ['persist'],
        orphanRemoval: true
    )]
    private Collection $projectTag;

    public function __construct()
    {
        $this->projectTag = new ArrayCollection();
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function jsonSerialize(): array
    {
        $tags = array_map(
            static fn(ProjectTag $projectTag) => $projectTag->getTag()->jsonSerialize(),
            $this->projectTag->toArray()
        );

        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'tags' => $tags,
            'link' => $this->link,
            'image' => $this->image->jsonSerialize(),
            'user' => $this->user->jsonSerialize(),
        ];
    }

    public static function create(
        CreateProjectDto $projectDto,
        User $user,
        Image $image
    ): self {
        $project = new self();

        $project->title = $projectDto->title;
        $project->description = $projectDto->description;
        $project->link = $projectDto->link;
        $project->image = $image;
        $project->user = $user;

        return $project;
    }

    /** @param Tag[] $tags */
    public function addTags(array $tags): void
    {
        $this->projectTag->clear();
        foreach ($tags as $tag) {
            $this->projectTag->add(ProjectTag::create($this, $tag));
        }
    }

    public function update(
        UpdateProjectDto $projectDto,
        Image $image
    ): void {
        $this->title = $projectDto->title;
        $this->description = $projectDto->description;
        $this->link = $projectDto->link;
        $this->image = $image;
    }
}