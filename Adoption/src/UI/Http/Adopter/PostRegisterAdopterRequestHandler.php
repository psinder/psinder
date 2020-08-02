<?php

declare(strict_types=1);

namespace Sip\Psinder\Adoption\UI\Http\Adopter;

use Fig\Http\Message\StatusCodeInterface;
use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Log\LoggerInterface;
use Ramsey\Uuid\Uuid;
use Sip\Psinder\Adoption\Application\Command\Adopter\RegisterAdopter\RegisterAdopter;
use Sip\Psinder\SharedKernel\Application\Command\CommandBus;

final class PostRegisterAdopterRequestHandler implements RequestHandlerInterface
{
    private CommandBus $commandBus;
    private LoggerInterface $logger;

    public function __construct(CommandBus $commandBus, LoggerInterface $logger)
    {
        $this->commandBus = $commandBus;
        $this->logger     = $logger;
    }

    public function handle(ServerRequestInterface $request) : ResponseInterface
    {
        $this->logger->info('Registering adopter');
        /** @var PostRegisterAdopterRequest $dto */
        $dto = $request->getAttribute(PostRegisterAdopterRequest::class);

        $id = Uuid::uuid4()->toString();

        $this->commandBus->dispatch(new RegisterAdopter(
            $id,
            $dto->firstName,
            $dto->lastName,
            $dto->email,
            $dto->password,
            $dto->birthDate,
            $dto->gender
        ));

        return new JsonResponse(
            ['id' => $id],
            StatusCodeInterface::STATUS_CREATED
        );
    }
}
