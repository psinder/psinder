<?php

declare(strict_types=1);

namespace Sip\Psinder\SharedKernel\UI\Http\Middleware;

use Lcobucci\Clock\Clock;
use Lcobucci\JWT\Parser;
use Lcobucci\JWT\ValidationData;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Sip\Psinder\SharedKernel\UI\Http\Middleware\Authentication\AnonymousUser;
use Sip\Psinder\SharedKernel\UI\Http\Middleware\Authentication\AuthenticatedUser;
use Sip\Psinder\SharedKernel\UI\Http\Middleware\Authentication\LoggedInUser;

use function explode;

final class AuthenticationMiddleware implements MiddlewareInterface
{
    private Clock $clock;
    private string $issuer;

    public function __construct(Clock $clock, string $issuer)
    {
        $this->clock  = $clock;
        $this->issuer = $issuer;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $request = $request->withAttribute('user', new AnonymousUser());

        $authString = $request->getHeader('Authorization')[0] ?? null;

        if ($authString === null) {
            return $handler->handle($request);
        }

        $tokenString = explode(' ', $authString)[1] ?? null;

        if ($tokenString === null) {
            return $handler->handle($request);
        }

        $token = (new Parser())->parse($tokenString);

        $validationData = new ValidationData(
            $this->clock->now()->getTimestamp(),
            10
        );
        $validationData->setIssuer($this->issuer);

        $userId = $token->getClaim('jti');

        if ($token->validate($validationData) && ($userId !== null)) {
            $request = $request->withAttribute(AuthenticatedUser::class, new LoggedInUser(
                $userId,
                $token->getClaim('roles')
            ));
        }

        return $handler->handle($request);
    }
}
