<?php

declare(strict_types=1);

namespace OrangePortfolio\Core\Domain\Exception;

class UserNotFound extends NotFoundException
{
    public static function fromId(int $id): self
    {
        return new self(sprintf('Usuário com id "%s" não encontrado.', $id));
    }
}