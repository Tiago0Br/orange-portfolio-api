<?php

use Lcobucci\JWT\Configuration;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\Signer\Key\InMemory;
use OrangePortfolio\Core\Application\Auth\Authentication;
use OrangePortfolio\Core\Domain\Repository\UserRepositoryInterface;
use OrangePortfolio\Core\Domain\Service\LoginService;
use OrangePortfolio\Core\Domain\Service\RegisterUser;
use OrangePortfolio\Core\Infrastructure\Persistence\DoctrineOrm\UserRepositoryDoctrineOrm;
use Psr\Container\ContainerInterface;

// Auth
$container[Authentication::class] = static fn (ContainerInterface $container) =>
    new Authentication(
        Configuration::forSymmetricSigner(
            new Sha256(),
            InMemory::plainText(getenv('AUTH_TOKEN_SIGNER_KEY'))
        )
    );

// Services
$container[RegisterUser::class] = static fn (ContainerInterface $container) =>
    new RegisterUser(
        $container->get(UserRepositoryInterface::class)
    );

$container[LoginService::class] = static fn (ContainerInterface $container) =>
    new LoginService(
        $container->get(UserRepositoryInterface::class)
    );

// Repositories
$container[UserRepositoryInterface::class] = static fn (ContainerInterface $container) =>
    new UserRepositoryDoctrineOrm(
        $container->get('doctrine-orange')
    );