<?php

declare(strict_types=1);

use Laminas\Stratigility\Middleware\ErrorHandler;
use Mezzio\Application;
use Mezzio\Handler\NotFoundHandler;
use Mezzio\Helper\ServerUrlMiddleware;
use Mezzio\Helper\UrlHelperMiddleware;
use Mezzio\MiddlewareFactory;
use Mezzio\Router\Middleware\DispatchMiddleware;
use Mezzio\Router\Middleware\ImplicitHeadMiddleware;
use Mezzio\Router\Middleware\ImplicitOptionsMiddleware;
use Mezzio\Router\Middleware\MethodNotAllowedMiddleware;
use Mezzio\Router\Middleware\RouteMiddleware;
use Psr\Container\ContainerInterface;
use Sip\Psinder\SharedKernel\UI\Http\Middleware\AuthenticationMiddleware;
use Sip\Psinder\SharedKernel\UI\Http\Middleware\ExecutionContextMiddleware;
use Sip\Psinder\SharedKernel\UI\Http\Middleware\JsonDeserializeMiddleware;

return static function (Application $app, MiddlewareFactory $factory, ContainerInterface $container) : void {
    $app->pipe(ErrorHandler::class);
    $app->pipe(ExecutionContextMiddleware::class);
    $app->pipe(ServerUrlMiddleware::class);
    $app->pipe(RouteMiddleware::class);
    $app->pipe(ImplicitHeadMiddleware::class);
    $app->pipe(ImplicitOptionsMiddleware::class);
    $app->pipe(MethodNotAllowedMiddleware::class);
    $app->pipe(UrlHelperMiddleware::class);
    $app->pipe(JsonDeserializeMiddleware::class);
    $app->pipe(AuthenticationMiddleware::class);
    $app->pipe(DispatchMiddleware::class);
    $app->pipe(NotFoundHandler::class);
};
