<?php

declare(strict_types=1);

namespace OrangePortfolio\Core\Domain\Service;

use OrangePortfolio\Core\Domain\Dto\LoginDto;
use OrangePortfolio\Core\Domain\Entity\User;
use OrangePortfolio\Core\Domain\Exception\InvalidEmailOrPassword;
use OrangePortfolio\Core\Domain\Repository\UserRepositoryInterface;

class LoginService
{
    public function __construct(private readonly UserRepositoryInterface $userRepository)
    {
    }

    public function login(LoginDto $loginDto): User
    {
        $user = $this->userRepository->getByEmail($loginDto->email);

        if ($user && $user->validatePassword($loginDto->password)) {
            return $user;
        }

        throw InvalidEmailOrPassword::throw();
    }
}