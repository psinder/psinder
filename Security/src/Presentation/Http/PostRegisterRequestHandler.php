<?php

declare(strict_types=1);

namespace Sip\Psinder\Security\Presentation\Http;

use Fig\Http\Message\StatusCodeInterface;
use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Ramsey\Uuid\Uuid;
use Sip\Psinder\Security\Application\UseCase\RegisterUser;
use Sip\Psinder\Security\Application\UseCase\RegisterUserDTO;
use function assert;

final class PostRegisterRequestHandler implements RequestHandlerInterface
{
    /** @var RegisterUser */
    private $registerUser;

    public function __construct(RegisterUser $registerUser)
    {
        $this->registerUser = $registerUser;
    }

    public function handle(ServerRequestInterface $request) : ResponseInterface
    {
        $requestData = $request->getAttribute(PostRegisterRequest::class);

        assert($requestData instanceof PostRegisterRequest);

        $id = Uuid::uuid4()->toString();

        $this->registerUser->handle(new RegisterUserDTO(
            $id,
            $requestData->type,
            $requestData->email,
            $requestData->password,
            $requestData->context
        ));

        return new JsonResponse(
            ['id' => $id],
            StatusCodeInterface::STATUS_CREATED
        );
    }
}
