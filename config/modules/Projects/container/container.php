<?php

use OrangePortfolio\Projects\Domain\Repository\ProjectRepositoryInterface;
use OrangePortfolio\Projects\Domain\Service\CreateProject;
use OrangePortfolio\Projects\Domain\Service\UpdateProject;
use OrangePortfolio\Projects\Infrastructure\Persistence\DoctrineOrm\ProjectRepositoryDoctrineOrm;
use Psr\Container\ContainerInterface;

// Services
$container[CreateProject::class] = static fn (ContainerInterface $container) => new CreateProject(
    $container->get(ProjectRepositoryInterface::class)
);

$container[UpdateProject::class] = static fn (ContainerInterface $container) => new UpdateProject(
    $container->get(ProjectRepositoryInterface::class)
);

// Repositories
$container[ProjectRepositoryInterface::class] = static fn (ContainerInterface $container) => new ProjectRepositoryDoctrineOrm(
    $container->get('doctrine-orange')
);