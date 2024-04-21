<?php

declare(strict_types=1);

use OrangePortfolio\Projects\Application\Rest\CreateProjectAction;
use OrangePortfolio\Projects\Application\Rest\GetProjectAction;
use Slim\App;

/** @var App $app */
$container = $app->getContainer();
$app->post('/users/{user_id}/projects', new CreateProjectAction($container));
$app->get('/projects/{project_id}', new GetProjectAction($container));