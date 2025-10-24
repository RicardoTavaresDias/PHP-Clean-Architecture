<?php

namespace App\infrastructure\http\routers;

use Slim\App;
use Slim\Routing\RouteCollectorProxy;
use App\infrastructure\http\Middleware\Authenticated;
use App\shared\ContainerDependency;
use App\infrastructure\http\Middleware\UserAuthorization;

class Router {
  public function register(App $app): void {
    $containerDependency = new ContainerDependency();

    // Router Login
    $app->post("/", [$containerDependency->loginController, 'authenticate']);

    // Router User
    $app->group('/user', function (RouteCollectorProxy $group) use ($containerDependency) {
      $group->get('', [$containerDependency->userController, 'show'])
        ->add(UserAuthorization::authorization(['admin']));

      $group->post('', [$containerDependency->userController, 'create'])
        ->add(UserAuthorization::authorization(['admin', 'member']));

      $group->get('/{id}', [$containerDependency->userController, 'byidUser'])
        ->add(UserAuthorization::authorization(['admin', 'member']));

      $group->delete('/{id}', [$containerDependency->userController, 'removeUser'])
        ->add(UserAuthorization::authorization(['admin']));
      
      $group->patch('/{id}', [$containerDependency->userController, 'updateUser'])
        ->add(UserAuthorization::authorization(['admin', 'member']));
    })
     ->add(new Authenticated());
  }
}