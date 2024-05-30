<?php

declare(strict_types=1);

namespace OrangePortfolio\Core\Application\Auth;

use Exception;
use Lcobucci\JWT\Configuration;
use Lcobucci\JWT\Validation\Constraint\SignedWith;
use OrangePortfolio\Core\Domain\Entity\User;
use OrangePortfolio\Core\Domain\Exception\InvalidToken;

class Authentication
{
    public function __construct(
        private readonly Configuration $config
    ) {
    }

    public function generateToken(User $user): string
    {
        return $this->config->builder()
            ->issuedBy('orange-portfolio')
            ->identifiedBy((string) $user->getId())
            ->permittedFor('orange-portfolio')
            ->getToken($this->config->signer(), $this->config->signingKey())
            ->toString();
    }

    public function authenticate(string $inputToken): int
    {
        try {
            $token = $this->config->parser()->parse($inputToken);
        } catch (Exception) {
            throw InvalidToken::throw();
        }

        $this->config->setValidationConstraints(new SignedWith($this->config->signer(), $this->config->signingKey()));

        if (! $this->config->validator()->validate($token, ...$this->config->validationConstraints())) {
            throw InvalidToken::throw();
        }

        return (int) $token->claims()->get('jti');
    }
}