<?php

use Slim\Factory\AppFactory;
use App\infrastructure\http\Middleware\ErrorHandling;
use App\infrastructure\http\routers\Router;

require __DIR__ . '/../../../vendor/autoload.php';

$app = AppFactory::create();
$app->addRoutingMiddleware();

// Register routes
$userRouters = new Router();
$userRouters->register($app);

// Adiciona o middleware de erros personalizado
$app->add(new ErrorHandling());

// Run app
$app->run();