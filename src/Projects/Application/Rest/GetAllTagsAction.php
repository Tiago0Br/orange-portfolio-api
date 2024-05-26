<?php

declare(strict_types=1);

namespace OrangePortfolio\Projects\Application\Rest;

use JsonException;
use OrangePortfolio\Projects\Domain\Entity\Tag;
use OrangePortfolio\Projects\Domain\Repository\TagRepositoryInterface;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Http\StatusCode;

class GetAllTagsAction
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
        /** @var TagRepositoryInterface $tagRepository */
        $tagRepository = $this->container->get(TagRepositoryInterface::class);
        $tags = $tagRepository->getAll();

        $body = $response->getBody();
        $responseBody = array_map(fn (Tag $tag) => $tag->jsonSerialize(), $tags);
        $body->write((string) json_encode($responseBody, JSON_THROW_ON_ERROR));

        return $response
            ->withStatus(StatusCode::HTTP_OK)
            ->withHeader('Content-Type', 'application/json')
            ->withBody($body);
    }
}