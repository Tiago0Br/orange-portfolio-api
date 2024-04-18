<?php

namespace OrangePortfolio\Core\Application\Middleware;

use Doctrine\DBAL\Exception;
use InvalidArgumentException;
use PDOException;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class ErrorHandler
{
    public function __invoke(Request $request, Response $response, callable $next): Response
    {
        try {
            $response = $next($request, $response);
        } catch (InvalidArgumentException $e) {
            $response = $response
                ->withStatus(400)
                ->withJson([
                    'type'        => 'InvalidParameter',
                    'messages'    => [$e->getMessage()],
                ]);
        } catch (PDOException | Exception) {
            $response = $response
                ->withStatus(500)
                ->withJson([
                    'type'        => 'databaseError',
                    'message'     => 'Erro ao realizar operação no banco de dados',
                ]);
        }

        return $response;
    }
}