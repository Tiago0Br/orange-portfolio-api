<?php

declare(strict_types=1);

use OrangePortfolio\Projects\Application\Rest\CreateProjectAction;
use OrangePortfolio\Projects\Application\Rest\GetProjectAction;
use OrangePortfolio\Projects\Application\Rest\UpdateProjectAction;
use Slim\App;

/** @var App $app */
$container = $app->getContainer();

$app->post('/users/{user_id}/projects', new CreateProjectAction($container));

$app->group('/projects/{id}', function (App $app) {
    $container = $app->getContainer();

    $app->get('', new GetProjectAction($container));
    $app->put('', new UpdateProjectAction($container));
});