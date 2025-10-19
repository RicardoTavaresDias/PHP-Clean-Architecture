<?php

namespace Ricardo\Phpcleanarchitecture\infrastructure\repositories;
use Ricardo\Phpcleanarchitecture\infrastructure\repositories\dtos\RepositoryDtoInterface;

class Repository implements RepositoryDtoInterface {
  private string $file = __DIR__ . '/data.json';

  private function read(): array {
    if (!file_exists($this->file)) {
        return [];
    }

    $json = file_get_contents($this->file);
    return json_decode($json, true) ?? [];
}

private function write(array $data): void {
    file_put_contents($this->file, json_encode($data, JSON_PRETTY_PRINT));
}

  public function getAll(): array {
    return $this->read();
  }

  public function getById(string $id): ?array {
    $data = $this->read();
    return $data[$id] ?? null;
  }

  public function create(array $data): array {
    $all = $this->read();
    $id = uniqid();

    $object = [
      'id' => $id,
      'name' => $data['name'],
      'email' => $data['email'],
      'password' => $data['password'],
      'role' => $data['role']
    ];

    $all[$id] = $object;
    $this->write($all);
    return $object;
  }

  public function update(string $id, array $data): ?array {
    $all = $this->read();
    
    if (!isset($all[$id])) return null;

    $all[$id] = [
      'name' => $data['name'] ?? $all[$id]['name'],
      'email' => $data['email'] ?? $all[$id]['email'],
      'password' => $data['password'] ?? $all[$id]['password'],
      'role' => $data['role'] ?? $all[$id]['role']
    ];

    $this->write($all);
    return $all[$id];
  }

  public function delete(string $id): bool {
    $all = $this->read();
    if (!isset($all[$id])) return false;
    unset($all[$id]);
    $this->write($all);
    return true;
  }
}