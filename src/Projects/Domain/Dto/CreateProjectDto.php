<?php

declare(strict_types=1);

namespace OrangePortfolio\Projects\Domain\Dto;

use OrangePortfolio\Core\Domain\Helpers\ValidateParams;

class CreateProjectDto
{
    private function __construct(
        public readonly string $title,
        public readonly string $description,
        public readonly string $link,
        public readonly int $imageId,
        public readonly int $userId,
    ) {
    }

    public static function fromArray(array $params): self
    {
        self::validate($params);

        return new self(
            title: $params['title'],
            description: $params['description'],
            link: $params['link'],
            imageId: (int) $params['image_id'],
            userId: (int) $params['user_id'],
        );
    }

    private static function validate(array $params): void
    {
        ValidateParams::validateString(
            params: $params,
            fields: ['title', 'description', 'link'],
        );

        ValidateParams::validateInteger(
            params: $params,
            fields: ['image_id', 'user_id'],
        );
    }
}