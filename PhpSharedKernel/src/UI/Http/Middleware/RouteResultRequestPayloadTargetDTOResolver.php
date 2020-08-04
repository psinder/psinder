<?php

declare(strict_types=1);

namespace Sip\Psinder\SharedKernel\UI\Http\Middleware;

use Mezzio\Middleware\LazyLoadingMiddleware;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use ReflectionObject;
use Stringy\Stringy;
use Zend\Expressive\Router\RouteResult;

use function assert;
use function class_exists;
use function get_class;

final class RouteResultRequestPayloadTargetDTOResolver implements RequestPayloadTargetDTOResolver
{
    public function resolve(ServerRequestInterface $request): ?string
    {
        $routeResult = $request->getAttribute(RouteResult::class);
        assert($routeResult instanceof RouteResult || $routeResult === null);

        if ($routeResult !== null) {
            $matchedRoute = $routeResult->getMatchedRoute();

            if ($matchedRoute === false || $matchedRoute === null) {
                return null;
            }

            $handlerClass = $this->determineRequestHandlerClass($matchedRoute->getMiddleware());
            if ($handlerClass === null) {
                return null;
            }

            $handlerClass = Stringy::create($handlerClass);

            if (! $handlerClass->endsWith('Handler')) {
                return null;
            }

            $requestObjectClass = (string) $handlerClass->substr(0, -7);

            if (! class_exists($requestObjectClass)) {
                return null;
            }

            return $requestObjectClass;
        }

        return null;
    }

    private function determineRequestHandlerClass(MiddlewareInterface $middleware): ?string
    {
        if ($middleware instanceof LazyLoadingMiddleware) {
            $class              = new ReflectionObject($middleware);
            $middlewareProperty = $class->getProperty('middlewareName');
            $middlewareProperty->setAccessible(true);

            return $middlewareProperty->getValue($middleware);
        }

        return get_class($middleware);
    }
}
