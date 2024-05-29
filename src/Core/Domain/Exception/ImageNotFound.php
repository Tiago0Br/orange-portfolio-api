<?php

declare(strict_types=1);

namespace OrangePortfolio\Core\Domain\Exception;

class ImageNotFound extends NotFoundException
{
    public static function fromId(int $id): self
    {
        return new self(sprintf('Image com o ID "%s" não encontrada.', $id));
    }
}