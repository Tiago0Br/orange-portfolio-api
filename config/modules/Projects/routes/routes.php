<?php

declare(strict_types=1);

use OrangePortfolio\Projects\Application\Rest\CreateProjectAction;
use OrangePortfolio\Projects\Application\Rest\CreateTagAction;
use OrangePortfolio\Projects\Application\Rest\DeleteProjectAction;
use OrangePortfolio\Projects\Application\Rest\GetProjectAction;
use OrangePortfolio\Projects\Application\Rest\UpdateProjectAction;
use Slim\App;

/** @var App $app */
$container = $app->getContainer();

$app->post('/users/{user_id}/projects', new CreateProjectAction($container));

$app->group('/projects/{id}', function (App $app) use ($container) {
    $app->get('', new GetProjectAction($container));
    $app->put('', new UpdateProjectAction($container));
    $app->delete('', new DeleteProjectAction($container));
});

$app->post('/tags', new CreateTagAction($container));