<?php

declare(strict_types=1);

namespace OrangePortfolio\Projects\Domain\Dto;

use Assert\Assert;

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
        array_map(static function ($key) use ($params) {
            Assert::that($params[$key])
                ->notNull("O campo '$key' é obrigatório")
                ->string("O campo '$key' deve ser uma string")
                ->notEmpty("O campo '$key' não pode estar vazio");
        }, ['title', 'description', 'link']);

        array_map(static function ($key) use ($params) {
            Assert::that($params[$key])
                ->notNull("O campo '$key' é obrigatório")
                ->integerish("O campo '$key' deve ser um número");
        }, ['image_id', 'user_id']);
    }
}