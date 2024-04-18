<?php

use OrangePortfolio\Core\Domain\Repository\UserRepositoryInterface;
use OrangePortfolio\Core\Domain\Service\RegisterUser;
use OrangePortfolio\Core\Infrastructure\Persistence\DoctrineOrm\UserRepositoryDoctrineOrm;
use Psr\Container\ContainerInterface;

// Services
$container[RegisterUser::class] = static fn (ContainerInterface $container) => new RegisterUser(
    $container->get(UserRepositoryInterface::class),
);

// Doctrine
$container[UserRepositoryInterface::class] = static fn (ContainerInterface $container) => new UserRepositoryDoctrineOrm(
    $container->get('doctrine-orange')
);