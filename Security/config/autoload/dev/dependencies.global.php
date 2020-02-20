<?php

declare(strict_types=1);

use Mezzio\Container;
use Mezzio\Middleware\ErrorResponseGenerator;

return [
    'dependencies' => [
        'invokables' => [],
        'factories'  => [
            ErrorResponseGenerator::class       => Container\WhoopsErrorResponseGeneratorFactory::class,
            'Mezzio\Whoops'            => Container\WhoopsFactory::class,
            'Mezzio\WhoopsPageHandler' => Container\WhoopsPageHandlerFactory::class,
        ],
    ],
];
