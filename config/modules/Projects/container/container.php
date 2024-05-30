<?php

use OrangePortfolio\Core\Domain\Repository\ImageRepositoryInterface;
use OrangePortfolio\Core\Domain\Repository\UserRepositoryInterface;
use OrangePortfolio\Projects\Domain\Repository\ProjectRepositoryInterface;
use OrangePortfolio\Projects\Domain\Repository\TagRepositoryInterface;
use OrangePortfolio\Projects\Domain\Service\CreateProject;
use OrangePortfolio\Projects\Domain\Service\CreateTag;
use OrangePortfolio\Projects\Domain\Service\DeleteProject;
use OrangePortfolio\Projects\Domain\Service\UpdateProject;
use OrangePortfolio\Projects\Infrastructure\Persistence\DoctrineOrm\ProjectRepositoryDoctrineOrm;
use OrangePortfolio\Projects\Infrastructure\Persistence\DoctrineOrm\TagRepositoryDoctrineOrm;
use Psr\Container\ContainerInterface;

// Services
$container[CreateProject::class] = static fn (ContainerInterface $container) => new CreateProject(
    $container->get(ProjectRepositoryInterface::class),
    $container->get(TagRepositoryInterface::class),
    $container->get(UserRepositoryInterface::class),
    $container->get(ImageRepositoryInterface::class)
);

$container[UpdateProject::class] = static fn (ContainerInterface $container) => new UpdateProject(
    $container->get(ProjectRepositoryInterface::class),
    $container->get(TagRepositoryInterface::class),
    $container->get(ImageRepositoryInterface::class)
);

$container[DeleteProject::class] = static fn (ContainerInterface $container) => new DeleteProject(
    $container->get(ProjectRepositoryInterface::class)
);

$container[CreateTag::class] = static fn (ContainerInterface $container) => new CreateTag(
    $container->get(TagRepositoryInterface::class)
);

// Repositories
$container[ProjectRepositoryInterface::class] = static fn (ContainerInterface $container) => new ProjectRepositoryDoctrineOrm(
    $container->get('doctrine-orange')
);

$container[TagRepositoryInterface::class] = static fn (ContainerInterface $container) => new TagRepositoryDoctrineOrm(
    $container->get('doctrine-orange')
);