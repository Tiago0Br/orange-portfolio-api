<?php

declare(strict_types=1);

namespace OrangePortfolio\Core\Domain\Dto;

use OrangePortfolio\Core\Domain\Helpers\ValidateParams;

class LoginDto
{
    private function __construct(
        public readonly string $email,
        public readonly string $password
    ) {
    }

    public static function fromArray(array $params): self
    {
        ValidateParams::validateString(
            params: $params,
            fields: ['email', 'password']
        );

        return new self(
            email: $params['email'],
            password: $params['password']
        );
    }
}