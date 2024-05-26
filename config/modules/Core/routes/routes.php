<?php

declare(strict_types=1);

use OrangePortfolio\Core\Application\Rest\LoginAction;
use OrangePortfolio\Core\Application\Rest\RegisterUserAction;
use Slim\App;

/** @var App $app */
$container = $app->getContainer();
$app->post('/users', new RegisterUserAction($container));
$app->post('/login', new LoginAction($container));