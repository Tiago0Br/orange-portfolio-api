<?php

namespace OrangePortfolio\Core\Domain\Service;

use OrangePortfolio\Core\Domain\Dto\RegisterUserDto;
use OrangePortfolio\Core\Domain\Entity\User;
use OrangePortfolio\Core\Domain\Repository\UserRepositoryInterface;

class RegisterUser
{
    public function __construct(private readonly UserRepositoryInterface $userRepository)
    {
    }

    public function save(RegisterUserDto $userDto): User
    {
        $user = User::create($userDto);
        $this->userRepository->store($user);

        return $user;
    }
}