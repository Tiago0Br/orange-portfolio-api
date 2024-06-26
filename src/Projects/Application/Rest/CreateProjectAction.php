<?php

declare(strict_types=1);

namespace OrangePortfolio\Projects\Application\Rest;

use JsonException;
use OrangePortfolio\Projects\Domain\Dto\CreateProjectDto;
use OrangePortfolio\Projects\Domain\Service\CreateProject;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Http\StatusCode;

class CreateProjectAction
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
        $createProjectDto = CreateProjectDto::fromArray(
            array_merge(
                (array) $request->getParsedBody(),
                $request->getQueryParams()
            )
        );

        /** @var CreateProject $createProject */
        $createProject = $this->container->get(CreateProject::class);
        $project = $createProject->save($createProjectDto);

        $body = $response->getBody();
        $body->write((string) json_encode($project->jsonSerialize(), JSON_THROW_ON_ERROR));

        return $response
            ->withStatus(StatusCode::HTTP_CREATED)
            ->withHeader('Content-Type', 'application/json')
            ->withBody($body);
    }
}