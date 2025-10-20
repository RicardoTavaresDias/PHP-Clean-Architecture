<?php

namespace App\usecases\users;

use App\domain\entity\UserEntity;
use App\infrastructure\repositories\dtos\RepositoryDtoInterface;
use App\usecases\dtos\UpdateDtoInterface;
use App\domain\exceptions\utils\AppError;
use Nyra\Zod\Z;

require_once __DIR__ . '/../dtos/UsecaseDtoInterface.php';

class UpdateUsecase implements UpdateDtoInterface {
  private RepositoryDtoInterface $repository;
  private UserEntity $userEntity;

  public function __construct(
    RepositoryDtoInterface $repository,
    UserEntity $userEntity
  ) {
    $this->repository = $repository;
    $this->userEntity = $userEntity;
  }

  public function execute(string $id, array $data) {
    if (!$id) {
      throw new AppError("Error Processing Request", 400);
    }

    $pased = $this->validation($data);
    return $this->repository->update($id, $pased);
  }

  private function validation ($data) {
    $schema = Z::object([
      'name' => Z::string()
        ->min(3, "Nome deve ter no mínimo 3 caracteres")
        ->max(20, "Nome deve ter no máximo 20 caracteres")
        ->optional(),
      'email' => Z::string()
        ->email("Email inválido")
        ->optional(),
      'password' => Z::string()
        ->min(6, "Senha deve ter no mínimo 6 caracteres")
        ->max(8, "Senha deve ter no máximo 8 caracteres")
        ->optional(),
      'role' => Z::enum(['admin', 'member'])
        ->optional()
    ]);

    return $schema->parse($data);
  }
}