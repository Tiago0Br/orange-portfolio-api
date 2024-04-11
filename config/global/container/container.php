<?php

declare(strict_types=1);

use Slim\Container;

$container = new Container();

$modules = require __DIR__ . '/../modules.php';
foreach ($modules as $module) {
    require_once sprintf(__DIR__ . '/../../modules/%s/container/container.php', $module);
}

return $container;
