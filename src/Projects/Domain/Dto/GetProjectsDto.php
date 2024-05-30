<?php

declare(strict_types=1);

namespace OrangePortfolio\Projects\Domain\Dto;

use OrangePortfolio\Core\Domain\Helpers\ValidateParams;

class GetProjectsDto
{
    private function __construct(
        public readonly ?string $tags,
        public readonly int $onlyMyProjects,
    ) {
    }

    public static function fromArray(array $params): self
    {
        ValidateParams::validateNumbersSeparatedByComma(
            params: $params,
            fields: ['tags'],
            required: false
        );

        ValidateParams::validateInteger(
            params: $params,
            fields: ['only_my_projects'],
            required: false
        );

        return new self(
            tags: $params['tags'] ?? null,
            onlyMyProjects: $params['only_my_projects'] ? (int) $params['only_my_projects'] : 0
        );
    }
}