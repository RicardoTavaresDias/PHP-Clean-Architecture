<?php

use Slim\App;
use Slim\Routing\RouteCollectorProxy;
use App\infrastructure\http\Middleware\Authenticated;
use App\shared\ContainerDependency;
use App\infrastructure\http\Middleware\UserAuthorization;

$containerDependency = new ContainerDependency();

return function (App $app) use ($containerDependency) {

  // Router User
  $app->group('/user', function (RouteCollectorProxy $group) use ($containerDependency) {
    $group->get('', [$containerDependency->userController, 'show'])
      ->add((new UserAuthorization())(['admin']));

    $group->post('', [$containerDependency->userController, 'create'])
      ->add((new UserAuthorization())(['admin', 'member']));

    $group->get('/{id}', [$containerDependency->userController, 'byidUser'])
      ->add((new UserAuthorization())(['admin', 'member']));

    $group->delete('/{id}', [$containerDependency->userController, 'removeUser'])
      ->add((new UserAuthorization())(['admin']));
    
    $group->patch('/{id}', [$containerDependency->userController, 'updateUser'])
      ->add((new UserAuthorization())(['admin', 'member']));
  });
  //  ->add(new Authenticated());
};