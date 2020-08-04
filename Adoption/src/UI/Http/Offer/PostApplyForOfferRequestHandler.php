<?php

declare(strict_types=1);

namespace Sip\Psinder\Adoption\UI\Http\Offer;

use Fig\Http\Message\StatusCodeInterface;
use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Sip\Psinder\Adoption\Application\Command\Adopter\ApplyForAdoption\ApplyForAdoption;
use Sip\Psinder\SharedKernel\Application\Command\CommandBus;
use Sip\Psinder\SharedKernel\UI\Http\Middleware\Authentication\AuthenticatedUser;
use Sip\Psinder\SharedKernel\UI\Http\Middleware\Authentication\LoggedInUser;
use function assert;

final class PostApplyForOfferRequestHandler implements RequestHandlerInterface
{
    protected CommandBus $commandBus;

    public function __construct(CommandBus $commandBus)
    {
        $this->commandBus = $commandBus;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $user = $request->getAttribute(AuthenticatedUser::class);
        assert($user instanceof LoggedInUser);
        $adopterId = $user->userId();
        $offerId = $request->getAttribute('offerId');
        $this->commandBus->dispatch(new ApplyForAdoption(
            $adopterId,
            $offerId
        ));

        return new JsonResponse(null, StatusCodeInterface::STATUS_CREATED);
    }
}
