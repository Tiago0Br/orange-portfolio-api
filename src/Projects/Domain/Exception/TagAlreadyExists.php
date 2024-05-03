<?php

declare(strict_types=1);

namespace OrangePortfolio\Projects\Domain\Exception;

use DomainException;

class TagAlreadyExists extends DomainException
{
    public static function fromName(string $name): self
    {
        return new self(sprintf('Tag "%s" já existe', $name));
    }
}