<?php

namespace Ricardo\Phpcleanarchitecture\infrastructure\http\controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Ricardo\Phpcleanarchitecture\usecases\ContrutorUserUsecases;

class UserController {
    private ContrutorUserUsecases $usecase;

    public function __construct(ContrutorUserUsecases $usecase) {
        $this->usecase = $usecase;
    }

    public function create(Request $request, Response $response) {
        // Lê o corpo da requisição e transforma de JSON para array associativo
        $data = json_decode($request->getBody()->getContents(), true);
        $user = $this->usecase->create->execute($data);

        $response->getBody()->write(json_encode($user));
        return $response->withStatus(201);
    }

    public function show (Request $request, Response $response) {
        $users = $this->usecase->getAll->execute();
        $response->getBody()->write(json_encode($users));
        return $response->withStatus(200);
    }

    public function byidUser (Request $request, Response $response, array $args) {
        $id = $args['id'] ?? null;
        $users = $this->usecase->byId->execute($id);

        $response->getBody()->write(json_encode($users));
        return $response->withStatus(200);
    }

    public function removeUser (Request $request, Response $response, array $args) {
        $id = $args['id'] ?? null;
        $users = $this->usecase->remove->execute($id);

        if (!$users) {
            $response->getBody()->write(json_encode(['message' => "Usuário não encontrado"]));
            return $response->withStatus(401);
        }

        $response->getBody()->write(json_encode(['message' => "Usuário Removido com sucesso."]));
        return $response->withStatus(200);
    }

    public function updateUser (Request $request, Response $response, array $args) {
        $id = $args['id'] ?? null;
        $data = json_decode($request->getBody()->getContents(), true);

        $users = $this->usecase->update->execute($id, $data);
        
        $response->getBody()->write(json_encode($users));
        return $response->withStatus(200);
    }
}