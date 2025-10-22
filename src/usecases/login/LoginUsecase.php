<?php

namespace App\usecases\login;

use Nyra\Zod\Z;
use Firebase\JWT\JWT;
use App\shared\config\Env;
use App\shared\utils\AppError;
use App\infrastructure\repositories\dtos\RepositoryDtoInterface;

class LoginUsecase  {
  private RepositoryDtoInterface $repository;

  public function __construct(RepositoryDtoInterface $repository) {
    $this->repository = $repository;
  }

  public function execute($data) {
    $user = $this->validation($data);

    $dataRepository = $this->repository->getAll();

    // Filter
    $userResult = array_filter($dataRepository, function($value) use ($user) {
      return $value['email'] === $user['email'];
    });

    if(!$userResult) {
      throw new AppError("Email ou senha inválidos", 401);
    }

    // Pega primeiro elemeto da array encontrado.
    $firstUser = reset($userResult);
    $token = $this->token($firstUser);

    return ['token' => $token, 'firstUser' => $firstUser];
  } 

  private function validation ($data) {
    $schema = Z::object([
      'email' => Z::string()
        ->email("Email inválido"),
      'password' => Z::string()
        ->min(6, "Senha deve ter no mínimo 6 caracteres")
        ->max(8, "Senha deve ter no máximo 8 caracteres")
    ]);

    return $schema->parse($data);
  }

  private function token ($firstUser) {
    $token = JWT::encode([
      'id' => $firstUser['id'],
      'role' => $firstUser['role'],
      'exp' => time() + 15
    ], Env::get()['SECRET'], 'HS256');

    return $token;
  }
}