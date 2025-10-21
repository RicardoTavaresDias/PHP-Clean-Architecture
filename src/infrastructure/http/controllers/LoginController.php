<?php

namespace App\infrastructure\http\controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\usecases\login\LoginUsecase; 

class LoginController {
  private LoginUsecase $loginUsecase;

  public function __construct(LoginUsecase $loginUsecase) {
    $this->loginUsecase = $loginUsecase;
  }

  public function authenticate (Request $request, Response $response) {
    $body = $request->getBody();
    $data = json_decode($body, true);

    $result = $this->loginUsecase->execute($data);

    $response->getBody()->write(json_encode(['user' => [
      'id' => $result['firstUser']['id'],
      'role' => $result['firstUser']['role']
    ], 'token' => $result['token'] ]));

    return $response->withStatus(200);
  }
}