<?php

declare(strict_types=1);

namespace OrangePortfolio\Projects\Application\Rest;

use JsonException;
use OrangePortfolio\Projects\Domain\Dto\GetProjectByIdDto;
use OrangePortfolio\Projects\Domain\Repository\ProjectRepositoryInterface;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Http\StatusCode;

class GetProjectByIdAction
{
    public function __construct(private readonly ContainerInterface $container)
    {
    }

    /**
     * @throws JsonException
     * @throws NotFoundExceptionInterface
     * @throws ContainerExceptionInterface
     */
    public function __invoke(Request $request, Response $response, $args): Response
    {
        $getProjectDto = GetProjectByIdDto::fromArray($args);

        /** @var ProjectRepositoryInterface $projectRepository */
        $projectRepository = $this->container->get(ProjectRepositoryInterface::class);
        $project = $projectRepository->getById($getProjectDto->projectId);

        $body = $response->getBody();
        $body->write((string) json_encode($project->jsonSerialize(), JSON_THROW_ON_ERROR));

        return $response
            ->withStatus(StatusCode::HTTP_OK)
            ->withHeader('Content-Type', 'application/json')
            ->withBody($body);
    }
}