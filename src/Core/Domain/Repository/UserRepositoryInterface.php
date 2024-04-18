<?php

namespace OrangePortfolio\Core\Domain\Repository;

use OrangePortfolio\Core\Domain\Entity\User;

interface UserRepositoryInterface
{
    public function store(User $user): void;
}