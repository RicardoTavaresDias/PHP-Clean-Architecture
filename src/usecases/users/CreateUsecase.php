<?php

namespace App\usecases\users;

use App\domain\entity\UserEntity;
use App\infrastructure\repositories\dtos\RepositoryDtoInterface;
use App\usecases\dtos\CreateDtoInterface;

require_once __DIR__ . '/../dtos/UsecaseDtoInterface.php';

use Nyra\Zod\Z;

class CreateUsecase implements CreateDtoInterface {
  private RepositoryDtoInterface $repository;
  private UserEntity $userEntity;

  public function __construct(
    RepositoryDtoInterface $repository,
    UserEntity $userEntity
  ) {
    $this->repository = $repository;
    $this->userEntity = $userEntity;
  }

  public function execute(array $data): ?array {
    $pased = $this->validation($data);

    $this->userEntity->setName($pased['name']);
    $this->userEntity->setEmail($pased['email']);
    $this->userEntity->setPassword($pased['password']);
    $this->userEntity->setRole($pased['role']);

    $userArray = [
        'name' => $this->userEntity->getName(),
        'email' => $this->userEntity->getEmail(),
        'password' => $this->userEntity->getPassword(),
        'role' => $this->userEntity->getRole()
    ];

    return $this->repository->create($userArray);
  }

  private function validation ($data) {
    $schema = Z::object([
      'name' => Z::string()
        ->min(3, "Nome deve ter no mínimo 3 caracteres")
        ->max(20, "Nome deve ter no máximo 20 caracteres"),
      'email' => Z::string()
        ->email("Email inválido"),
      'password' => Z::string()
        ->min(6, "Senha deve ter no mínimo 6 caracteres")
        ->max(8, "Senha deve ter no máximo 8 caracteres"),
      'role' => Z::enum(['admin', 'member'])
    ]);

    return $schema->parse($data);
  }
}