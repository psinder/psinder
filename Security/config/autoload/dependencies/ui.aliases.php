<?php

declare(strict_types=1);

use Sip\Psinder\SharedKernel\UI\Http\Middleware\RequestPayloadTargetDTOResolver;
use Sip\Psinder\SharedKernel\UI\Http\Middleware\RouteResultRequestPayloadTargetDTOResolver;

return [
    'dependencies' => [
        'aliases' => [
            RequestPayloadTargetDTOResolver::class => RouteResultRequestPayloadTargetDTOResolver::class,
        ],
    ],
];
