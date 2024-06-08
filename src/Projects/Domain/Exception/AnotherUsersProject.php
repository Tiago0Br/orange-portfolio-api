<?php

namespace OrangePortfolio\Projects\Domain\Exception;

use OrangePortfolio\Core\Domain\Exception\UnauthorizedException;

class AnotherUsersProject extends UnauthorizedException
{
    public static function fromId(int $id): self
    {
        return new self(sprintf("O projeto não pertence ao usuário com ID '%s'", $id));
    }
}