<?php

declare(strict_types=1);

use Laminas\ConfigAggregator\ConfigAggregator;
use Laminas\ConfigAggregator\PhpFileProvider;
use Laminas\ZendFrameworkBridge\ConfigPostProcessor;
use Mezzio\Router\FastRouteRouter\ConfigProvider;

$env = getenv('APP_ENV');

$aggregator = new ConfigAggregator([
    ConfigProvider::class,
    \Laminas\HttpHandlerRunner\ConfigProvider::class,

    \Mezzio\Helper\ConfigProvider::class,
    \Mezzio\ConfigProvider::class,
    \Mezzio\Router\ConfigProvider::class,
    \Laminas\Di\ConfigProvider::class,
    \Xtreamwayz\Expressive\Messenger\ConfigProvider::class,

    // Load application config in a pre-defined order in such a way that local settings
    // overwrite global settings. (Loaded as first to last):
    //   - `global.php`
    //   - `*.global.php`
    //   - `local.php`
    //   - `*.local.php`
    new PhpFileProvider(realpath(__DIR__) . '/autoload/{{,*.}global,{,*.}local}.php'),

    new PhpFileProvider(realpath(__DIR__) . '/autoload/dependencies/*.php'),
    new PhpFileProvider(realpath(__DIR__) . '/autoload/dependencies/packages/*.php'),

    // Load env-specific config if it exists
    new PhpFileProvider(realpath(__DIR__) . sprintf('/autoload/%s/{{,*.}global,{,*.}local}.php', $env)),
], null, [ConfigPostProcessor::class]);

$config = $aggregator->getMergedConfig();

$config['env'] = $env;

return $config;
