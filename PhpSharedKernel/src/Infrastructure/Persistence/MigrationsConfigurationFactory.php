<?php

declare(strict_types=1);

namespace Sip\Psinder\SharedKernel\Infrastructure\Persistence;

use Doctrine\Migrations\Configuration\Configuration;
use Psr\Container\ContainerInterface;
use Roave\PsrContainerDoctrine\AbstractFactory;
use Roave\PsrContainerDoctrine\ConnectionFactory;
use function class_exists;

final class MigrationsConfigurationFactory extends AbstractFactory
{
    protected function createWithConfig(ContainerInterface $container, string $configKey) : ?Configuration
    {
        $config = $this->retrieveConfig($container, $configKey, 'migrations');

        $configuration = null;

        if (class_exists('\Doctrine\DBAL\Migrations\Configuration\Configuration')) {
            $configuration = new Configuration(
                $this->retrieveDependency(
                    $container,
                    $configKey,
                    'connection',
                    ConnectionFactory::class
                )
            );
        }

        if (class_exists('\Doctrine\Migrations\Configuration\Configuration')) {
            $configuration = new Configuration(
                $this->retrieveDependency(
                    $container,
                    $configKey,
                    'connection',
                    ConnectionFactory::class
                )
            );
        }

        if ($configuration === null) {
            return null;
        }

        $configuration->setMigrationsNamespace($config['namespace']);
        $configuration->setName($config['name']);
        $configuration->setMigrationsDirectory($config['directory']);
        $configuration->setMigrationsTableName($config['table']);
        $configuration->setMigrationsColumnLength(64);

        return $configuration;
    }

    /**
     * @return mixed[]
     *
     * @phpstan-return array<string, mixed>
     */
    protected function getDefaultConfig(string $configKey) : array
    {
        return [
            'directory' => 'data/migrations',
            'name'      => 'Doctrine database migrations',
            'namespace' => 'Migrations',
            'table'     => 'migrations',
        ];
    }
}
