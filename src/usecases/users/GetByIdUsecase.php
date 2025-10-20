<?php

namespace App\usecases\users;

use App\domain\entity\UserEntity;
use App\infrastructure\repositories\dtos\RepositoryDtoInterface;
use App\usecases\dtos\GetByIdDtoInterface;
use App\domain\exceptions\AppError;

require_once __DIR__ . '/../dtos/UsecaseDtoInterface.php';

class GetByIdUsecase implements GetByIdDtoInterface {
  private RepositoryDtoInterface $repository;
  private UserEntity $userEntity;

  public function __construct(
    RepositoryDtoInterface $repository,
    UserEntity $userEntity
  ) {
    $this->repository = $repository;
    $this->userEntity = $userEntity;
  }

  public function execute(string $id) {
    if (!$id) {
      throw new AppError("Error Processing Request", 400);
    }

    return $this->repository->getById($id);
  }
}