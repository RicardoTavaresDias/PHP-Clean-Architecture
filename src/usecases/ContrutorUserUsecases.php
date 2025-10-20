<?php

namespace App\usecases;

use App\usecases\users\CreateUsecase;
use App\usecases\users\GetAllUsecase;
use App\usecases\users\GetByIdUsecase;
use App\usecases\users\UpdateUsecase;
use App\usecases\users\RemoveUsecase;

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