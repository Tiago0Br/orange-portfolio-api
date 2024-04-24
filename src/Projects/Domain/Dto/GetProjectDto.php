<?php

namespace OrangePortfolio\Projects\Domain\Dto;

use OrangePortfolio\Core\Domain\Helpers\ValidateParams;

class GetProjectDto
{
    private function __construct(public readonly int $projectId)
    {
    }

    public static function fromArray(array $params): self
    {
        ValidateParams::validateInteger($params, ['id']);

        return new self(
            projectId: (int) $params['id']
        );
    }
}