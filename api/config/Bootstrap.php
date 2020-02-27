<?php

declare(strict_types=1);

use Psr\Container\ContainerInterface;
use Laminas\ConfigAggregator\ConfigAggregator;
use Laminas\ConfigAggregator\PhpFileProvider;

class Bootstrap
{
    /** @var ContainerInterface */
    private $container;

    public function __construct()
    {
        $this->init();
    }

    private function init(): void
    {
        $this->container = $this->initContainer();
    }

    private function initContainer(): ContainerInterface
    {
        $aggregator = new ConfigAggregator([
            new PhpFileProvider(__DIR__ . '/common/*.php'),
            new PhpFileProvider(__DIR__ . '/' . ($_ENV['API_ENV'] ?: 'prod') . '/*.php'),
        ]);

        $config = $aggregator->getMergedConfig();

        $builder = new DI\ContainerBuilder();
        $builder->addDefinitions($config);

        return $builder->build();
    }

    public function getContainer(): ContainerInterface
    {
        return $this->container;
    }
}
