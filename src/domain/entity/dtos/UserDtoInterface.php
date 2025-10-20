<?php

namespace App\domain\entity\dtos;

interface UserDtoInterface
{
    public function setName(string $name);
    public function setEmail(string $email);
    public function setPassword(string $password);
    public function setRole(string $role);
    public function getName(): string;
    public function getEmail(): string;
    public function getPassword(): string;
    public function getRole(): string;
}
