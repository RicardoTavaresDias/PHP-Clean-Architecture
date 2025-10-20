<?php

namespace App\infrastructure\http\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Slim\Psr7\Response;

class UserAuthorization {
  public function __invoke(array $role) {
    return function (ServerRequestInterface $request, RequestHandlerInterface $handler)use ($role): ResponseInterface {
      $data = json_decode($request->getBody()->getContents(), true);
      $roleUser = $data['role'] ?? null;

      if (!$roleUser) {
        $response = new Response();
        $response->getBody()->write(json_encode([ 'message' => "Não autorizado." ]));

        return $response->withStatus(400)
                ->withHeader('Content-Type', 'application/json');
      }

      if (!in_array($roleUser, $role)) {
        $response = new Response();
        $response->getBody()->write(json_encode([ 'message' => "Não autorizado." ]));

        return $response->withStatus(400)
                ->withHeader('Content-Type', 'application/json');
      }

      return $handler->handle($request);
    };
  }
}