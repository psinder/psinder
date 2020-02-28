<?php

declare(strict_types=1);

namespace Sip\Psinder\SharedKernel\Infrastructure\Persistence;

use ContainerInteropDoctrine\AbstractFactory;
use ContainerInteropDoctrine\ConnectionFactory;
use Psr\Container\ContainerInterface;

final class MigrationsConfigurationFactory extends AbstractFactory
{
    protected function createWithConfig(ContainerInterface $container, $configKey)
    {
        $config = $this->retrieveConfig($container, $configKey, 'migrations');

        $configuration = null;

        if (class_exists('\Doctrine\DBAL\Migrations\Configuration\Configuration')) {
            $configuration = new \Doctrine\DBAL\Migrations\Configuration\Configuration(
                $this->retrieveDependency(
                    $container,
                    $configKey,
                    'connection',
                    ConnectionFactory::class
                )
            );
        }

        if (class_exists('\Doctrine\Migrations\Configuration\Configuration')) {
            $configuration = new \Doctrine\Migrations\Configuration\Configuration(
                $this->retrieveDependency(
                    $container,
                    $configKey,
                    'connection',
                    ConnectionFactory::class
                )
            );
        }

        $configuration->setMigrationsNamespace($config['namespace']);
        $configuration->setName($config['name']);
        $configuration->setMigrationsDirectory($config['directory']);
        $configuration->setMigrationsTableName($config['table']);

        return $configuration;
    }

    /**
     * @phpstan-return array<string, mixed>
     * @return mixed[]
     */
    protected function getDefaultConfig(string $configKey): array
    {
        return [
            'directory' => 'data/migrations',
            'name'      => 'Doctrine database migrations',
            'namespace' => 'Migrations',
            'table'     => 'migrations'
        ];
    }
}
