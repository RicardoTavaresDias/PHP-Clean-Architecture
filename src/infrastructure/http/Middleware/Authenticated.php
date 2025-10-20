<?php

namespace App\infrastructure\http\Middleware;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Psr7\Response;

class Authenticated {
    private Response $response;

    public function __construct(){
        $this->response = new Response();
    }
    
    public function __invoke(Request $request, RequestHandler $handler) {
        $auth = $request->getHeaderLine('Authorization');

        if (!$auth){
            $this->response->getBody()->write(json_encode(['message' => "Token JWT não encontrado"]));
            return $this->response->withStatus(401);
        }

        return $handler->handle($request);
    }
}