<?php

declare(strict_types=1);

namespace OrangePortfolio\Core\Application\Rest;

use JsonException;
use OrangePortfolio\Core\Domain\Dto\RegisterUserDto;
use OrangePortfolio\Core\Domain\Service\RegisterUser;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Http\StatusCode;

class RegisterUserAction
{
    public function __construct(private readonly ContainerInterface $container)
    {
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     * @throws JsonException
     */
    public function __invoke(Request $request, Response $response): Response
    {
        $userDto = RegisterUserDto::fromArray(
            (array) $request->getParsedBody()
        );

        $body = $response->getBody();

        /** @var RegisterUser $registerUser */
        $registerUser = $this->container->get(RegisterUser::class);
        $user = $registerUser->save($userDto);

        $body->write((string) json_encode($user->jsonSerialize(), JSON_THROW_ON_ERROR));

        return $response
            ->withStatus(StatusCode::HTTP_CREATED)
            ->withHeader('Content-Type', 'application/json')
            ->withBody($body);
    }
}