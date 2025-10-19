<?php

namespace Ricardo\Phpcleanarchitecture\infrastructure\http\Middleware;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;

class Authenticated {
    public function __invoke(Request $request, RequestHandler $handler) {
        $auth = $request->getHeaderLine('Authorization');

        if (!$auth){
            $response = new \Slim\Psr7\Response(); // Criar um novo objeto Response
            $response->getBody()->write(json_encode(['message' => "Token JWT não encontrado"]));
            return $response->withStatus(401);
        }

        $response = $handler->handle($request);
    }
}