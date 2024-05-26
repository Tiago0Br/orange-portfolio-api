<?php

namespace OrangePortfolio\Core\Domain\Exception;

class InvalidEmailOrPassword extends UnauthorizedException
{
    public static function throw(): self
    {
        return new self('E-mail e/ou senha inválidos! Por favor, verifique.');
    }
}