<?php

declare(strict_types=1);

namespace OrangePortfolio\Projects\Application\Rest;

use JsonException;
use OrangePortfolio\Projects\Domain\Dto\CreateTagDto;
use OrangePortfolio\Projects\Domain\Service\CreateTag;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Http\StatusCode;

class CreateTagAction
{
    public function __construct(private readonly ContainerInterface $container)
    {
    }

    /**
     * @throws JsonException
     * @throws NotFoundExceptionInterface
     * @throws ContainerExceptionInterface
     */
    public function __invoke(Request $request, Response $response): Response
    {
        $createTagDto = CreateTagDto::fromArray(
            (array) $request->getParsedBody()
        );

        /** @var CreateTag $createTag */
        $createTag = $this->container->get(CreateTag::class);

        $tag = $createTag->save($createTagDto->name);

        $body = $response->getBody();
        $body->write((string) json_encode($tag->jsonSerialize(), JSON_THROW_ON_ERROR));

        return $response
            ->withStatus(StatusCode::HTTP_CREATED)
            ->withHeader('Content-Type', 'application/json')
            ->withBody($body);
    }
}