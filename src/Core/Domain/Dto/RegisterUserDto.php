<?php

namespace OrangePortfolio\Core\Domain\Dto;

use OrangePortfolio\Core\Domain\Helpers\ValidateParams;

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
        ValidateParams::validateString(
            params: $params,
            fields: ['name', 'email', 'password'],
        );

        ValidateParams::validateInteger(
            params: $params,
            fields: ['selfie_id'],
            required: false
        );
    }
}