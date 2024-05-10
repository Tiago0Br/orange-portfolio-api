<?php

namespace OrangePortfolio\Projects\Domain\Dto;

use OrangePortfolio\Core\Domain\Helpers\ValidateParams;

class UpdateProjectDto
{
    protected function __construct(
        public readonly int $id,
        public readonly string $title,
        public readonly string $description,
        public readonly string $link,
        public readonly int $imageId,
        public readonly array $tags
    ) {
    }

    public static function fromArray(array $params): self
    {
        self::validate($params);

        return new self(
            id: (int) $params['id'],
            title: $params['title'],
            description: $params['description'],
            link: $params['link'],
            imageId: (int) $params['image_id'],
            tags: array_map(fn ($tag) => (int) $tag, $params['tags'])
        );
    }

    protected static function validate(array $params): void
    {
        ValidateParams::validateInteger(
            params: $params,
            fields: ['id', 'image_id']
        );

        ValidateParams::validateString(
            params: $params,
            fields: ['title', 'description', 'link']
        );

        ValidateParams::validateIntegerArray(
            params: $params,
            fields: ['tags'],
        );
    }
}