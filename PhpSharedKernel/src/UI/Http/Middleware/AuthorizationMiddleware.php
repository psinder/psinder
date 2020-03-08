<?php

declare(strict_types=1);

namespace Sip\Psinder\SharedKernel\UI\Http\Middleware;

use Fig\Http\Message\StatusCodeInterface;
use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Sip\Psinder\SharedKernel\UI\Http\Middleware\Authentication\AuthenticatedUser;
use Sip\Psinder\SharedKernel\UI\Http\Middleware\Authorization\AuthorizationRule;

final class AuthorizationMiddleware implements MiddlewareInterface
{
    private AuthorizationRule $rule;

    public function __construct(AuthorizationRule $rule)
    {
        $this->rule = $rule;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler) : ResponseInterface
    {
        /** @var AuthenticatedUser $user */
        $user = $request->getAttribute(AuthenticatedUser::class);

        if (! $this->rule->isAuthorized($user)) {
            return new Response(StatusCodeInterface::STATUS_UNAUTHORIZED);
        }

        return $handler->handle($request);
    }
}
