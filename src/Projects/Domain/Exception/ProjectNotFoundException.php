<?php

namespace OrangePortfolio\Projects\Domain\Exception;

use OrangePortfolio\Core\Domain\Exception\NotFoundException;

class ProjectNotFoundException extends NotFoundException
{
    public static function fromId(int $id): self
    {
        return new self(sprintf("Projeto com o ID '%s' não encontrado.", $id));
    }
}