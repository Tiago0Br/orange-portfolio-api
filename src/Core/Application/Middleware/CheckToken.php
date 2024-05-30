<?php

declare(strict_types=1);

namespace OrangePortfolio\Core\Application\Middleware;

use OrangePortfolio\Core\Application\Auth\Authentication;
use OrangePortfolio\Core\Application\Auth\HeaderToken;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class CheckToken
{
    public function __construct(private readonly ContainerInterface $container)
    {
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function __invoke(Request $request, Response $response, callable $next): Response
    {
        /** @var Authentication $authentication */
        $authentication = $this->container->get(Authentication::class);
        $authentication->authenticate(HeaderToken::get());

        return $next($request, $response);
    }
}