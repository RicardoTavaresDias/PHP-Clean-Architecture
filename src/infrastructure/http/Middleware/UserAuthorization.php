<?php

namespace App\infrastructure\http\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Slim\Psr7\Response;

class UserAuthorization {
  public static function authorization (array $role) {
    return function (ServerRequestInterface $request, RequestHandlerInterface $handler) use ($role): ResponseInterface {
      $response = new Response();

      $data = $request->getAttribute('user');
      $roleUser = $data['role'] ?? null;

      if (!$roleUser) {
        $response->getBody()->write(json_encode([ 'message' => "Não autorizado." ]));

        return $response->withStatus(400)
                ->withHeader('Content-Type', 'application/json');
      }

      if (!in_array($roleUser, $role)) {
        $response->getBody()->write(json_encode([ 'message' => "Não autorizado." ]));

        return $response->withStatus(400)
                ->withHeader('Content-Type', 'application/json');
      }

      return $handler->handle($request);
    };
  }
}