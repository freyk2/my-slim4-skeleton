<?php
declare(strict_types=1);

use Slim\Factory\AppFactory;
use Symfony\Component\Dotenv\Dotenv;

chdir(dirname(__DIR__));
require 'vendor/autoload.php';
require 'config/Bootstrap.php';

if (file_exists('.env')) {
    (new Dotenv())->load('.env');
}

$bootstrap = new Bootstrap();
$container = $bootstrap->getContainer();

AppFactory::setContainer($container);
$app = AppFactory::create();

$app->addBodyParsingMiddleware();

$routes = require 'config/routes.php';
$routes($app);

$middlewares = require 'config/middleware.php';
$middlewares($app);

$app->run();