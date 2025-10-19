<?php

use Slim\Factory\AppFactory;
use Ricardo\Phpcleanarchitecture\infrastructure\http\Middleware\ErrorHandling;

require __DIR__ . '/../../../vendor/autoload.php';

$app = AppFactory::create();
$app->addRoutingMiddleware();

// Register routes
(require __DIR__ . '/routers/index.php')($app);

// Adiciona o middleware de erros personalizado
$app->add(new ErrorHandling());

// Run app
$app->run();