<?php

declare(strict_types=1);

namespace OrangePortfolio\Projects\Domain\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Table(name: 'project_tag')]
#[ORM\Entity]
class ProjectTag
{
    #[ORM\Id]
    #[ORM\Column(name: 'id', type: Types::INTEGER)]
    #[ORM\GeneratedValue(strategy: 'AUTO')]
    private int $id;

    #[ORM\ManyToOne(targetEntity: Project::class)]
    #[ORM\JoinColumn(name: 'project_id', referencedColumnName: 'id')]
    private Project $project;

    #[ORM\ManyToOne(targetEntity: Tag::class)]
    #[ORM\JoinColumn(name: 'tag_id', referencedColumnName: 'id')]
    private Tag $tag;
}