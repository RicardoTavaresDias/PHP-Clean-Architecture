<?php

namespace App\usecases\dtos;

interface CreateDtoInterface
{
    public function execute(array $data);
}

interface UpdateDtoInterface
{
    public function execute(string $id, array $data);
}

interface RemoveDtoInterface
{
    public function execute(string $id);
}

interface GetByIdDtoInterface
{
    public function execute(string $id);
}

interface GetAllDtoInterface
{
    public function execute(): array;
}
