<?php

namespace App\infrastructure\http\Middleware;

use App\shared\AppError;
use Nyra\Zod\Errors\ZodError;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Slim\Psr7\Response;

class ErrorHandling implements MiddlewareInterface {
    private ResponseInterface $response;

    public function __construct(){
        $this->response = new Response();
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface {
        try {
            return $handler->handle($request);
        } catch (\Throwable $e) {
            if($e instanceof AppError) {
                $this->response->getBody()->write(json_encode([
                    'message' => $e->getMessage(),
                ]));

                return $this->response->withStatus($e->getStatusCode())
                    ->withHeader('Content-Type', 'application/json');
            }

            if ($e instanceof ZodError) {
                $this->response->getBody()->write(json_encode([
                    'message' => 'Validation error',
                    'issues'  => $e->getIssues(),
                ]));

                return $this->response->withStatus(400)
                    ->withHeader('Content-Type', 'application/json');
            }
        
            $this->response->getBody()->write(json_encode([
                'message' => $e->getMessage(),
                'error'   => method_exists($e, 'getMeta') ? $e->getMeta() : null,
            ]));

            return $this->response->withStatus(500)
                            ->withHeader('Content-Type', 'application/json');
        }
    }
}
