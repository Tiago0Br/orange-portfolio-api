<?php

namespace OrangePortfolio\Core\Domain\Dto;

use Assert\Assert;

class RegisterUserDto
{
    private function __construct(
        public readonly string $name,
        public readonly string $email,
        public readonly ?int $selfieId,
        public readonly string $password
    ) {
    }

    public static function fromArray(array $params): self
    {
        self::validate($params);

        return new self(
            name: $params['name'],
            email: $params['email'],
            selfieId: $params['selfie_id'] ? (int) $params['selfie_id'] : null,
            password: $params['password']
        );
    }

    private static function validate(array $params): void
    {
        array_map(static function ($key) use ($params) {
            Assert::that($params[$key])
                ->notNull("O campo '$key' é obrigatório")
                ->notEmpty("O campo '$key' não pode estar vazio")
                ->string("O campo '$key' deve ser uma string");
        }, ['name', 'email', 'password']);

        if (isset($params['selfie_id'])) {
            Assert::that($params['selfie_id'])
                ->notEmpty("O campo 'selfie_id' não pode estar vazio")
                ->integerish("O campo 'selfie_id' deve ser um  número");
        }
    }
}