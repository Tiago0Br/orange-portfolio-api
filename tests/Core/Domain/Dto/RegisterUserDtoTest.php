<?php

declare(strict_types=1);

namespace OrangePortfolio\Tests\Core\Domain\Dto;

use InvalidArgumentException;
use OrangePortfolio\Core\Domain\Dto\RegisterUserDto;
use OrangePortfolio\Core\Domain\Helpers\ArrayHelpers;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class RegisterUserDtoTest extends TestCase
{
    #[Test]
    public function fromArrayShouldWork(): void
    {
        $params = [
            'name' => 'Tiago Lopes',
            'email' => 'tiagoteste@gmail.com',
            'password' => 'Senha123',
            'selfie_id' => rand(1, 100),
        ];

        $registerUserDto = RegisterUserDto::fromArray($params);

        self::assertSame($params['name'], $registerUserDto->name);
        self::assertSame($params['email'], $registerUserDto->email);
        self::assertSame($params['password'], $registerUserDto->password);
        self::assertSame($params['selfie_id'], $registerUserDto->selfieId);
    }

    #[Test]
    #[DataProvider('errorProvider')]
    public function fromArrayShouldFail(array $data, string $exceptionMessage): void
    {
        self::expectException(InvalidArgumentException::class);
        self::expectExceptionMessage($exceptionMessage);

        RegisterUserDto::fromArray($data);
    }

    public static function errorProvider(): array
    {
        $params = [
            'name' => 'Tiago Lopes',
            'email' => 'tiagoteste@gmail.com',
            'password' => 'Senha123',
            'selfie_id' => rand(1, 100),
        ];

        return [
            'fromArrayShouldFailWithNameNull' => [
                'data' => ArrayHelpers::changeValue($params, 'name', null),
                'exceptionMessage' => "O campo 'name' é obrigatório"
            ],
            'fromArrayShouldFailWithNameEmpty' => [
                'data' => ArrayHelpers::changeValue($params, 'name', ''),
                'exceptionMessage' => "O campo 'name' não pode estar vazio"
            ],
            'fromArrayShouldFailWithNameHasInvalidType' => [
                'data' => ArrayHelpers::changeValue($params, 'name', 5),
                'exceptionMessage' => "O campo 'name' deve ser uma string"
            ],
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
            'fromArrayShouldFailWithSelfieIdHasInvalidType' => [
                'data' => ArrayHelpers::changeValue($params, 'selfie_id', 'a'),
                'exceptionMessage' => "O campo 'selfie_id' deve ser um número"
            ],
        ];
    }
}