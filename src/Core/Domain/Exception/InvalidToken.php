<?php

namespace OrangePortfolio\Core\Domain\Exception;

class InvalidToken extends UnauthorizedException
{
    public static function throw(): self
    {
        return new self('Token inválido ou não informado');
    }
}