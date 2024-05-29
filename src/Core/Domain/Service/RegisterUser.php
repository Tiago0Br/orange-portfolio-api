<?php

namespace OrangePortfolio\Core\Domain\Service;

use OrangePortfolio\Core\Domain\Dto\RegisterUserDto;
use OrangePortfolio\Core\Domain\Entity\User;
use OrangePortfolio\Core\Domain\Repository\ImageRepositoryInterface;
use OrangePortfolio\Core\Domain\Repository\UserRepositoryInterface;

class RegisterUser
{
    public function __construct(
        private readonly UserRepositoryInterface $userRepository,
        private readonly ImageRepositoryInterface $imageRepository
    ) {
    }

    public function save(RegisterUserDto $userDto): User
    {
        $selfie = $this->imageRepository->getById($userDto->selfieId);
        $user = User::create($userDto, $selfie);
        $this->userRepository->store($user);

        return $user;
    }
}