<?php

declare(strict_types=1);

namespace Sip\Psinder\Adoption\UI\Http\Shelter;

use Fig\Http\Message\StatusCodeInterface;
use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Ramsey\Uuid\Uuid;
use Sip\Psinder\Adoption\Application\Command\Address;
use Sip\Psinder\Adoption\Application\Command\Shelter\RegisterShelter\RegisterShelter;
use Sip\Psinder\SharedKernel\Application\Command\CommandBus;

final class PostRegisterShelterRequestHandler implements RequestHandlerInterface
{
    private CommandBus $commandBus;

    public function __construct(CommandBus $commandBus)
    {
        $this->commandBus = $commandBus;
    }

    public function handle(ServerRequestInterface $request) : ResponseInterface
    {
        /** @var PostRegisterShelterRequest $dto */
        $dto = $request->getAttribute(PostRegisterShelterRequest::class);

        $id = Uuid::uuid4()->toString();

        $this->commandBus->dispatch(new RegisterShelter(
            $id,
            $dto->name,
            new Address(
                $dto->addressStreet,
                $dto->addressNumber,
                $dto->addressPostalCode,
                $dto->addressCity
            ),
            $dto->email,
            $dto->password
        ));

        return new JsonResponse(
            ['id' => $id],
            StatusCodeInterface::STATUS_CREATED
        );
    }
}
