<?php

declare(strict_types=1);

namespace OrangePortfolio\Projects\Domain\Dto;

use OrangePortfolio\Core\Domain\Helpers\ValidateParams;

class DeleteProjectDto
{
    private function __construct(
        public readonly int $projectId,
        public readonly int $userId,
    ) {
    }

    public static function fromArray(array $params): self
    {
        ValidateParams::validateInteger($params, ['id', 'user_id']);

        return new self(
            projectId: (int) $params['id'],
            userId: (int) $params['user_id']
        );
    }
}