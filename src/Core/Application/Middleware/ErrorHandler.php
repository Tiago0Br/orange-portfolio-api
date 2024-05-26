<?php

namespace OrangePortfolio\Core\Application\Middleware;

use Doctrine\DBAL\Exception;
use DomainException;
use InvalidArgumentException;
use OrangePortfolio\Core\Domain\Exception\NotFoundException;
use OrangePortfolio\Core\Domain\Exception\UnauthorizedException;
use PDOException;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Throwable;

class ErrorHandler
{
    public function __invoke(Request $request, Response $response, callable $next): Response
    {
        try {
            $response = $next($request, $response);
        } catch (UnauthorizedException $e) {
            $response = $response
                ->withStatus(401)
                ->withJson([
                    'type'        => 'Unauthorized',
                    'messages'    => $e->getMessage(),
                ]);
        } catch (InvalidArgumentException $e) {
            $response = $response
                ->withStatus(400)
                ->withJson([
                    'type'        => 'InvalidParameter',
                    'messages'    => $e->getMessage(),
                ]);
        } catch (NotFoundException $e) {
            $response = $response
                ->withStatus(404)
                ->withJson([
                    'type'        => 'NotFound',
                    'message'     => $e->getMessage(),
                ]);
        } catch (DomainException $e) {
            $response = $response
                ->withStatus(409)
                ->withJson([
                    'type'        => 'BusinessLogic',
                    'message'     => $e->getMessage(),
                ]);
        }  catch (PDOException | Exception $e) {
            $response = $response
                ->withStatus(500)
                ->withJson([
                    'type'        => 'DatabaseError',
                    'message'     => 'Erro ao realizar operação no banco de dados: ' . $e->getMessage(),
                ]);
        } catch (Throwable $e) {
            $response = $response
                ->withStatus(500)
                ->withJson([
                    'type'        => 'InternalServerError',
                    'message'     => $e->getMessage(),
                ]);
        }

        return $response;
    }
}