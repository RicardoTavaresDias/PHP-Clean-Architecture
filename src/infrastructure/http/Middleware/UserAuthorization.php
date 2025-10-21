<?php

namespace App\infrastructure\http\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Slim\Psr7\Response;

class UserAuthorization {
  private ResponseInterface $response;

  public function __construct(){
    $this->response = new Response();
  }

  public function __invoke(array $role) {
    return function (ServerRequestInterface $request, RequestHandlerInterface $handler)use ($role): ResponseInterface {
      $data = $request->getAttribute('user');
      $roleUser = $data['role'] ?? null;

      if (!$roleUser) {
        $this->response->getBody()->write(json_encode([ 'message' => "Não autorizado." ]));

        return $this->response->withStatus(400)
                ->withHeader('Content-Type', 'application/json');
      }

      if (!in_array($roleUser, $role)) {
        $this->response->getBody()->write(json_encode([ 'message' => "Não autorizado." ]));

        return $this->response->withStatus(400)
                ->withHeader('Content-Type', 'application/json');
      }

      return $handler->handle($request);
    };
  }
}