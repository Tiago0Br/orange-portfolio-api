<?php

declare(strict_types=1);

use OrangePortfolio\Core\Application\Middleware\ErrorHandler;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Http\StatusCode;

$modules = require __DIR__ . '/../modules.php';

/** @var Slim\App $app */
$app->get('/', function (Request $request, Response $response) {
    $body = $response->getBody();
    $body->write((string) json_encode([
        'message' => 'API is running!!!',
    ], JSON_THROW_ON_ERROR));

    return $response
        ->withStatus(StatusCode::HTTP_OK)
        ->withHeader('Content-Type', 'application/json')
        ->withBody($body);
});

$app->add(new ErrorHandler());

foreach ($modules as $module) {
    require_once sprintf(__DIR__ . '/../../modules/%s/routes/routes.php', $module);
}