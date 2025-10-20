<?php

namespace App\infrastructure\repositories\dtos;

interface RepositoryDtoInterface
{
    public function getAll(): array;
    public function getById(string $id): ?array;
    public function create(array $data): array;
    public function update(string $id, array $data): ?array;
    public function delete(string $id): bool;
}
