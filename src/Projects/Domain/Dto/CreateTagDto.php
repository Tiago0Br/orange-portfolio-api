<?php

declare(strict_types=1);

namespace OrangePortfolio\Projects\Domain\Dto;

use Assert\Assert;
use OrangePortfolio\Core\Domain\Helpers\ValidateParams;

class CreateTagDto
{
    private function __construct(public readonly string $name)
    {
    }

    public static function fromArray(array $params): self
    {
        ValidateParams::validateString(
            params: $params,
            fields: ['name']
        );

        return new self($params['name']);
    }
}