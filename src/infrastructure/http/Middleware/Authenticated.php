<?php

namespace App\infrastructure\http\Middleware;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Psr7\Response;
use Exception;

use App\shared\config\Env;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

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

        $token = explode(" ", $auth)[1];

        if (!$token) {
            $this->response->getBody()->write(json_encode(['message' => "'Token JWT mal formatado'"]));
            return $this->response->withStatus(401);
        }

        $decoded = JWT::decode($token, new Key(Env::get()['SECRET'], 'HS256'));

        $request = $request->withAttribute('user', [
            'id' => $decoded->id,
            'role' => $decoded->role
        ]);

        return $handler->handle($request);
    }
}