<?php

namespace App\usecases\users;

use App\domain\entity\UserEntity;
use App\infrastructure\repositories\dtos\RepositoryDtoInterface;
use App\usecases\dtos\GetAllDtoInterface;

require_once __DIR__ . '/../dtos/UsecaseDtoInterface.php';

class GetAllUsecase implements GetAllDtoInterface {
  private RepositoryDtoInterface $repository;
  private UserEntity $userEntity;

  public function __construct(
    RepositoryDtoInterface $repository,
    UserEntity $userEntity
  ) {
    $this->repository = $repository;
    $this->userEntity = $userEntity;
  }

  public function execute(): array {
    return $this->repository->getAll();
  }
}