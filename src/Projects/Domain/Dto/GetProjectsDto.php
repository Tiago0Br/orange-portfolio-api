<?php

declare(strict_types=1);

namespace OrangePortfolio\Projects\Domain\Dto;

use OrangePortfolio\Core\Domain\Helpers\ValidateParams;

class GetProjectsDto
{
    private function __construct(public readonly ?string $tags)
    {
    }

    public static function fromArray(array $params): self
    {
        ValidateParams::validateNumbersSeparatedByComma(
            params: $params,
            fields: ['tags'],
            required: false
        );

        return new self(
            tags: $params['tags'] ?? null
        );
    }
}