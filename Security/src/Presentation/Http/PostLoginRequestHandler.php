<?php

declare(strict_types=1);

namespace Sip\Psinder\Security\Presentation\Http;

use Laminas\Diactoros\Response\EmptyResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Sip\Psinder\Security\Application\UseCase\LoginUser;
use Sip\Psinder\Security\Application\UseCase\LoginUserDTO;

use function assert;

final class PostLoginRequestHandler implements RequestHandlerInterface
{
    private UserTokenFactory $tokenFactory;

    private LoginUser $loginUser;

    public function __construct(LoginUser $loginUser, UserTokenFactory $tokenFactory)
    {
        $this->tokenFactory = $tokenFactory;
        $this->loginUser    = $loginUser;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $requestData = $request->getAttribute(PostLoginRequest::class);

        assert($requestData instanceof PostLoginRequest);

        $user = $this->loginUser->handle(new LoginUserDTO(
            $requestData->email,
            $requestData->password
        ));

        $token = $this->tokenFactory->create(
            $user->id()->toScalar(),
            $user->roles()->toScalarArray()
        );

        return (new EmptyResponse())
            ->withHeader('Authorization', 'Bearer ' . $token);
    }
}
