<?php

namespace App\shared\config;

use Dotenv\Dotenv;
use Nyra\Zod\Z;

class Env {
  private static ?array $env = null;

  public static function get() {
    $dotenv = Dotenv::createImmutable(__DIR__ . '/../../../');
    $dotenv->load();

    $envSchema = Z::object([
      'SECRET' => Z::string()
        ->min(1, "Sem variável de ambiente SECRET")
    ])
    ->strict();

    // Pega as variáveis de ambiente do PHP
    self::$env = $envSchema->parse($_ENV);
    return self::$env;
  }
}

// uso da variavel de ambiente SECRET
//$port = Env::get('SECRET');