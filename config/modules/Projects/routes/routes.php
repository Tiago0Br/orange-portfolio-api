<?php

declare(strict_types=1);

use OrangePortfolio\Projects\Application\Rest\CreateProjectAction;
use Slim\App;

/** @var App $app */
$container = $app->getContainer();
$app->post('/users/{user_id}/projects', new CreateProjectAction($container));