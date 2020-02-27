<?php
declare(strict_types=1);

use Slim\App;
use Slim\Interfaces\RouteCollectorProxyInterface as Group;
use App\Application\Actions\Token\TokenAction;
use App\Application\Actions\User\ListUsersAction;
use App\Application\Actions\User\ViewUserAction;

return function (App $app) {
    $app->get('/token', TokenAction::class . ':handle');

    $app->group('/users', function (Group $group) {
        $group->get('', ListUsersAction::class . ':handle');
        $group->get('/{id}', ViewUserAction::class . ':handle');
    });
};
