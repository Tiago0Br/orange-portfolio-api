<?php

declare(strict_types=1);

namespace OrangePortfolio\Tests\Projects\Domain\Dto;

use InvalidArgumentException;
use OrangePortfolio\Core\Domain\Helpers\ArrayHelpers;
use OrangePortfolio\Projects\Domain\Dto\CreateProjectDto;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class CreateProjectDtoTest extends TestCase
{
    #[Test]
    public function fromArrayShouldWork(): void
    {
        $params = [
            'title' => 'Título do projeto',
            'description' => 'Descrição do projeto',
            'link' => 'https://www.google.com.br',
            'image_id' => rand(1, 100),
            'user_id' => rand(1, 100),
            'tags' => [1, 2, 3],
        ];

        $createProjectDto = CreateProjectDto::fromArray($params);

        self::assertSame($params['title'], $createProjectDto->title);
        self::assertSame($params['description'], $createProjectDto->description);
        self::assertSame($params['link'], $createProjectDto->link);
        self::assertSame($params['image_id'], $createProjectDto->imageId);
        self::assertSame($params['user_id'], $createProjectDto->userId);
        self::assertSame($params['tags'], $createProjectDto->tags);
    }

    #[Test]
    #[DataProvider('errorProvider')]
    public function fromArrayShouldFail(array $data, string $exceptionMessage): void
    {
        self::expectException(InvalidArgumentException::class);
        self::expectExceptionMessage($exceptionMessage);

        CreateProjectDto::fromArray($data);
    }

    public static function errorProvider(): array
    {
        $params = [
            'title' => 'Título do projeto',
            'description' => 'Descrição do projeto',
            'link' => 'https://www.google.com.br',
            'image_id' => rand(1, 100),
            'user_id' => rand(1, 100),
            'tags' => [1, 2, 3],
        ];

        return [
            'fromArrayShouldFailWithTitleNull' => [
                'data' => ArrayHelpers::changeValue($params, 'title', null),
                'exceptionMessage' => "O campo 'title' é obrigatório"
            ],
            'fromArrayShouldFailWithTitleEmpty' => [
                'data' => ArrayHelpers::changeValue($params, 'title', ''),
                'exceptionMessage' => "O campo 'title' não pode estar vazio"
            ],
            'fromArrayShouldFailWithTitleHasInvalidType' => [
                'data' => ArrayHelpers::changeValue($params, 'title', 5),
                'exceptionMessage' => "O campo 'title' deve ser uma string"
            ],
            'fromArrayShouldFailWithDescriptionNull' => [
                'data' => ArrayHelpers::changeValue($params, 'description', null),
                'exceptionMessage' => "O campo 'description' é obrigatório"
            ],
            'fromArrayShouldFailWithDescriptionEmpty' => [
                'data' => ArrayHelpers::changeValue($params, 'description', ''),
                'exceptionMessage' => "O campo 'description' não pode estar vazio"
            ],
            'fromArrayShouldFailWithDescriptionHasInvalidType' => [
                'data' => ArrayHelpers::changeValue($params, 'description', 5),
                'exceptionMessage' => "O campo 'description' deve ser uma string"
            ],
            'fromArrayShouldFailWithLinkNull' => [
                'data' => ArrayHelpers::changeValue($params, 'link', null),
                'exceptionMessage' => "O campo 'link' é obrigatório"
            ],
            'fromArrayShouldFailWithLinkEmpty' => [
                'data' => ArrayHelpers::changeValue($params, 'link', ''),
                'exceptionMessage' => "O campo 'link' não pode estar vazio"
            ],
            'fromArrayShouldFailWithLinkHasInvalidType' => [
                'data' => ArrayHelpers::changeValue($params, 'link', 5),
                'exceptionMessage' => "O campo 'link' deve ser uma string"
            ],
            'fromArrayShouldFailWithUserIdNull' => [
                'data' => ArrayHelpers::changeValue($params, 'user_id', null),
                'exceptionMessage' => "O campo 'user_id' é obrigatório"
            ],
            'fromArrayShouldFailWithUserIdHasInvalidType' => [
                'data' => ArrayHelpers::changeValue($params, 'user_id', 'a'),
                'exceptionMessage' => "O campo 'user_id' deve ser um número"
            ],
            'fromArrayShouldFailWithImageIdNull' => [
                'data' => ArrayHelpers::changeValue($params, 'image_id', null),
                'exceptionMessage' => "O campo 'image_id' é obrigatório"
            ],
            'fromArrayShouldFailWithImageIdHasInvalidType' => [
                'data' => ArrayHelpers::changeValue($params, 'image_id', 'a'),
                'exceptionMessage' => "O campo 'image_id' deve ser um número"
            ],
            'fromArrayShouldFailWithTagsNull' => [
                'data' => ArrayHelpers::changeValue($params, 'tags', null),
                'exceptionMessage' => "O campo 'tags' é obrigatório"
            ],
            'fromArrayShouldFailWithTagsHasInvalidType' => [
                'data' => ArrayHelpers::changeValue($params, 'tags', 'aaa'),
                'exceptionMessage' => "O campo 'tags' deve ser um array"
            ],
            'fromArrayShouldFailWithTagsHasInvalidItemInArray' => [
                'data' => ArrayHelpers::changeValue($params, 'tags', [1, 2, 'aaaa']),
                'exceptionMessage' => "O campo 'tags' deve ser um array de inteiros"
            ],
        ];
    }
}