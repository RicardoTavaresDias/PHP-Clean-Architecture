<?php

namespace Ricardo\Phpcleanarchitecture\usecases\users;

use Ricardo\Phpcleanarchitecture\domain\entity\UserEntity;
use Ricardo\Phpcleanarchitecture\infrastructure\repositories\dtos\RepositoryDtoInterface;
use Ricardo\Phpcleanarchitecture\usecases\dtos\GetByIdDtoInterface;
use Ricardo\Phpcleanarchitecture\domain\exceptions\AppError;

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