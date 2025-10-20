<?php

namespace App\shared;

use App\domain\entity\UserEntity;
use App\infrastructure\repositories\Repository;
use App\infrastructure\http\controllers\UserController;
use App\usecases\users\CreateUsecase;
use App\usecases\users\GetAllUsecase;
use App\usecases\users\GetByIdUsecase;
use App\usecases\users\RemoveUsecase;
use App\usecases\users\UpdateUsecase;
use App\usecases\ContrutorUserUsecases;

class ContainerDependency {
    public Repository $repository;
    public UserEntity $userEntity;
    public CreateUsecase $createUsecase;
    public GetAllUsecase $getAllUsecase;
    public GetByIdUsecase $Byid;
    public RemoveUsecase $remove;
    public UpdateUsecase $update;
    public UserController $userController;
    public ContrutorUserUsecases $userUsecases;
    
    public function __construct() {
      $this->repository = new Repository();
      $this->userEntity = new UserEntity();

      // UserUsecases
      $this->createUsecase = new CreateUsecase(
        $this->repository,
        $this->userEntity
      );

      $this->getAllUsecase = new GetAllUsecase(
        $this->repository,
        $this->userEntity
      );

      $this->Byid = new GetByIdUsecase(
        $this->repository,
        $this->userEntity
      );

      $this->remove = new RemoveUsecase(
        $this->repository,
        $this->userEntity
      );

      $this->update = new UpdateUsecase(
        $this->repository,
        $this->userEntity
      );

      // Construtor da classe UserUsecases
      $this->userUsecases = new ContrutorUserUsecases(
        $this->createUsecase,
        $this->getAllUsecase,
        $this->Byid,
        $this->update,
        $this->remove
        
      );

      // Controler da classe UserController
      $this->userController = new UserController(
        $this->userUsecases
      );
    }
}