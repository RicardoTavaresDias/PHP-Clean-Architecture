<?php

namespace Ricardo\Phpcleanarchitecture\usecases;

use Ricardo\Phpcleanarchitecture\usecases\users\CreateUsecase;
use Ricardo\Phpcleanarchitecture\usecases\users\GetAllUsecase;
use Ricardo\Phpcleanarchitecture\usecases\users\GetByIdUsecase;
use Ricardo\Phpcleanarchitecture\usecases\users\UpdateUsecase;
use Ricardo\Phpcleanarchitecture\usecases\users\RemoveUsecase;

class ContrutorUserUsecases {
    public CreateUsecase $create;
    public GetAllUsecase $getAll;
    public GetByIdUsecase $byId;
    public UpdateUsecase $update;
    public RemoveUsecase $remove;

    public function __construct(
        CreateUsecase $create, 
        GetAllUsecase $getAll,
        GetByIdUsecase $byId,
        UpdateUsecase $update,
        RemoveUsecase $remove,
    ) {
        $this->create = $create;
        $this->getAll = $getAll;
        $this->byId = $byId;
        $this->update = $update;
        $this->remove = $remove;
    }
}