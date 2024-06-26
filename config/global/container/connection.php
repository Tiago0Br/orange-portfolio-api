<?php

use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMSetup;
use Psr\Container\ContainerInterface;

/**
 * @var ContainerInterface $container
 * @return EntityManager
 */
$container['doctrine-orange'] = static function () {
    $connectionParams = [
        'dbname'   => getenv('DB_NAME'),
        'user'     => getenv('DB_USER'),
        'password' => getenv('DB_PASS'),
        'host'     => getenv('DB_HOST'),
        'port'     => getenv('DB_PORT'),
        'driver'   => getenv('DB_DRIVER'),
        'charset'  => 'utf8',
    ];

    $config = ORMSetup::createAttributeMetadataConfiguration(
        paths: array(__DIR__."/src"),
        isDevMode: true,
    );

    $connection = DriverManager::getConnection($connectionParams, $config);

    return new EntityManager($connection, $config);
};