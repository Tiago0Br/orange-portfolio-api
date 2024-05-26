<?php

declare(strict_types=1);

namespace OrangePortfolio\Core\Application\Rest;

use JsonException;
use OrangePortfolio\Core\Application\Auth\Authentication;
use OrangePortfolio\Core\Domain\Dto\LoginDto;
use OrangePortfolio\Core\Domain\Service\LoginService;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Http\StatusCode;

class LoginAction
{
    public function __construct(private readonly ContainerInterface $container)
    {
    }

    /**
     * @throws NotFoundExceptionInterface
     * @throws ContainerExceptionInterface
     * @throws JsonException
     */
    public function __invoke(Request $request, Response $response): Response
    {
        $loginDto = LoginDto::fromArray((array) $request->getParsedBody());

        /** @var LoginService $loginService */
        $loginService = $this->container->get(LoginService::class);
        $user = $loginService->login($loginDto);

        /** @var Authentication $authentication */
        $authentication = $this->container->get(Authentication::class);
        $token = $authentication->generateToken($user);

        $body = $response->getBody();
        $responseBody = array_merge(
            ['user' => $user->jsonSerialize()],
            ['token' => $token]
        );
        $body->write((string) json_encode($responseBody, JSON_THROW_ON_ERROR));

        return $response
            ->withStatus(StatusCode::HTTP_CREATED)
            ->withHeader('Content-Type', 'application/json')
            ->withBody($body);
    }
}