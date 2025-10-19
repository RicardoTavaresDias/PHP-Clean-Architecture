<?php

namespace Ricardo\Phpcleanarchitecture\usecases\users;

use Ricardo\Phpcleanarchitecture\domain\entity\UserEntity;
use Ricardo\Phpcleanarchitecture\infrastructure\repositories\dtos\RepositoryDtoInterface;
use Ricardo\Phpcleanarchitecture\usecases\dtos\GetAllDtoInterface;

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