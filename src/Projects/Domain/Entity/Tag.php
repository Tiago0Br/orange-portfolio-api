<?php

declare(strict_types=1);

namespace OrangePortfolio\Projects\Domain\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Table(name: 'tags')]
#[ORM\Entity]
class Tag
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'AUTO')]
    #[ORM\Column(name: 'id', type: Types::INTEGER)]
    private int $id;

    #[ORM\Column(name: 'id', type: Types::STRING)]
    private string $name;
}