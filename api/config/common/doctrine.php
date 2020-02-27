<?php

declare(strict_types=1);

use Doctrine\Common\Cache\FilesystemCache;
use Doctrine\DBAL;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\Setup;
use Psr\Container\ContainerInterface;
use Ramsey\Uuid\Doctrine\UuidType;

return [
    EntityManagerInterface::class => static function (ContainerInterface $container) {
        $params = $container->get('config')['doctrine'];
        $config = Setup::createAnnotationMetadataConfiguration(
            $params['metadata_dirs'],
            $params['dev_mode'],
            $params['cache_dir'],
            new FilesystemCache(
                $params['cache_dir']
            ),
            false
        );
        foreach ($params['types'] as $type => $class) {
            if (!DBAL\Types\Type::hasType($type)) {
                DBAL\Types\Type::addType($type, $class);
            }
        }

        return EntityManager::create(
            $params['connection'],
            $config
        );
    },

    'config' => [
        'doctrine' => [
            'dev_mode' => $_ENV['API_ENV'] === 'dev',
            'cache_dir' => 'var/cache/doctrine',
            'metadata_dirs' => [
                'src/Domain',
            ],
            'connection' => [
                'url' => $_ENV['API_DB_URL']
            ],
            'types' => [
                'uuid' => UuidType::class
            ],
        ],
    ],
];
