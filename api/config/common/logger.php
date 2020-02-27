<?php
declare(strict_types=1);

use Monolog\Formatter\LineFormatter;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;

return [
    LoggerInterface::class => static function (ContainerInterface $container) {
        $settings = $container->get('config');
        $loggerSettings = $settings['logger'];

        $formatter = new LineFormatter();
        $formatter->includeStacktraces();
        $formatter->allowInlineLineBreaks();
        $formatter->ignoreEmptyContextAndExtra();

        $handler = new StreamHandler($loggerSettings['path']);
        $handler->setFormatter($formatter);

        $logger = new Logger($loggerSettings['name']);
        $logger->pushHandler($handler);
        return $logger;
    },

    'config' => [
        'logger' => [
            'name' => 'App',
            'path' => dirname(__DIR__) . '/../var/logs/app-' . date('Y-m-d') . '.log'
        ]
    ]
];
