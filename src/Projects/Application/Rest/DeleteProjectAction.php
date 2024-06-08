<?php

declare(strict_types=1);

namespace OrangePortfolio\Projects\Application\Rest;

use JsonException;
use OrangePortfolio\Projects\Domain\Dto\DeleteProjectDto;
use OrangePortfolio\Projects\Domain\Service\DeleteProject;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Http\StatusCode;

class DeleteProjectAction
{
    public function __construct(private readonly ContainerInterface $container)
    {
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     * @throws JsonException
     */
    public function __invoke(Request $request, Response $response, array $args): Response
    {
        $deleteProjectDto = DeleteProjectDto::fromArray(
            array_merge($args, $request->getQueryParams())
        );

        /** @var DeleteProject $deleteProject */
        $deleteProject = $this->container->get(DeleteProject::class);
        $deleteProject->delete($deleteProjectDto);

        $body = $response->getBody();
        $responseBody = [
            'message' => 'Projeto deletado com sucesso!'
        ];

        $body->write((string) json_encode($responseBody, JSON_THROW_ON_ERROR));

        return $response
            ->withStatus(StatusCode::HTTP_OK)
            ->withHeader('Content-Type', 'application/json')
            ->withBody($body);
    }
}