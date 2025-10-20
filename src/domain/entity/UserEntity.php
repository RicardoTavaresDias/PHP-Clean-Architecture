<?php

namespace App\domain\entity;

use App\domain\entity\dtos\UserDtoInterface;

class UserEntity implements UserDtoInterface{
  private string $name;
  private string $email;
  private string $password;
  private string $role;

  public function setName(string $name) {
    $this->name = $name;
  }

  public function setEmail(string $email) {
    $this->email = $email;
  }

  public function setPassword(string $password) {
    $this->password = $password;
  }

  public function setRole(string $role) {
    $this->role = $role;
  }

  public function getName(): string {
    return $this->name;
  }

  public function getEmail(): string {
    return $this->email;
  }

  public function getPassword(): string {
    return $this->password;
  }

  public function getRole(): string {
    return $this->role;
  }
}