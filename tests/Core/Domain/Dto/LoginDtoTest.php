<?php

declare(strict_types=1);

namespace OrangePortfolio\Tests\Core\Domain\Dto;

use InvalidArgumentException;
use OrangePortfolio\Core\Domain\Dto\LoginDto;
use OrangePortfolio\Core\Domain\Helpers\ArrayHelpers;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class LoginDtoTest extends TestCase
{
    #[Test]
    public function fromArrayShouldWork(): void
    {
        $params = [
            'email' => 'tiago@gmail.com',
            'password' => '123456',
        ];

        $loginDto = LoginDto::fromArray($params);

        self::assertSame($params['email'], $loginDto->email);
        self::assertSame($params['password'], $loginDto->password);
    }

    #[Test]
    #[DataProvider('errorProvider')]
    public function fromArrayShouldFail(array $data, string $exceptionMessage): void
    {
        self::expectException(InvalidArgumentException::class);
        self::expectExceptionMessage($exceptionMessage);

        LoginDto::fromArray($data);
    }

    public static function errorProvider(): array
    {
        $params = [
            'email' => 'tiago@gmail.com',
            'password' => '123456',
        ];

        return [
            'fromArrayShouldFailWithEmailNull' => [
                'data' => ArrayHelpers::changeValue($params, 'email', null),
                'exceptionMessage' => "O campo 'email' é obrigatório"
            ],
            'fromArrayShouldFailWithEmailEmpty' => [
                'data' => ArrayHelpers::changeValue($params, 'email', ''),
                'exceptionMessage' => "O campo 'email' não pode estar vazio"
            ],
            'fromArrayShouldFailWithEmailHasInvalidType' => [
                'data' => ArrayHelpers::changeValue($params, 'email', 5),
                'exceptionMessage' => "O campo 'email' deve ser uma string"
            ],
            'fromArrayShouldFailWithPasswordNull' => [
                'data' => ArrayHelpers::changeValue($params, 'password', null),
                'exceptionMessage' => "O campo 'password' é obrigatório"
            ],
            'fromArrayShouldFailWithPasswordEmpty' => [
                'data' => ArrayHelpers::changeValue($params, 'password', ''),
                'exceptionMessage' => "O campo 'password' não pode estar vazio"
            ],
            'fromArrayShouldFailWithPasswordHasInvalidType' => [
                'data' => ArrayHelpers::changeValue($params, 'password', 5),
                'exceptionMessage' => "O campo 'password' deve ser uma string"
            ],
        ];
    }
}