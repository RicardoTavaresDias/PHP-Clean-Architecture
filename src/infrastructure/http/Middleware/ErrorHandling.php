<?php

namespace Ricardo\Phpcleanarchitecture\infrastructure\http\Middleware;

use Ricardo\Phpcleanarchitecture\shared\AppError;
use Nyra\Zod\Errors\ZodError;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Slim\Psr7\Response;

class ErrorHandling implements MiddlewareInterface {
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface {
        try {
            return $handler->handle($request);
        } catch (\Throwable $e) {
            if($e instanceof AppError) {
                $response = new Response();
                $response->getBody()->write(json_encode([
                    'message' => $e->getMessage(),
                ]));

                return $response->withStatus($e->getStatusCode())
                    ->withHeader('Content-Type', 'application/json');
            }

            if ($e instanceof ZodError) {
                $response = new Response();
                $response->getBody()->write(json_encode([
                    'message' => 'Validation error',
                    'issues'  => $e->getIssues(),
                ]));

                return $response->withStatus(400)
                    ->withHeader('Content-Type', 'application/json');
            }
            
            $response = new Response();
            $response->getBody()->write(json_encode([
                'message' => $e->getMessage(),
                'error'   => method_exists($e, 'getMeta') ? $e->getMeta() : null,
            ]));

            return $response->withStatus(500)
                            ->withHeader('Content-Type', 'application/json');
        }
    }
}
