<?php
declare(strict_types=1);

use Tuupola\Middleware\JwtAuthentication;
use Slim\App;
use App\Infrastructure\Middleware\ValidationExceptionMiddleware;
use App\Infrastructure\Middleware\DomainExceptionMiddleware;

return function (App $app) {
    $app->add(new JwtAuthentication([
        "secret" => $_ENV['JWT_SECRET'],
        "ignore" => ["/token"]
    ]));

    if ($_ENV['prod']) {
        $app->addErrorMiddleware(true, true, true);
    } else {
        $app->add(new ValidationExceptionMiddleware());
        $app->add(new DomainExceptionMiddleware());
    }
};
