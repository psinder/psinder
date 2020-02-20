<?php

declare(strict_types=1);

namespace Sip\Psinder\Adoption\UI\Http\Shelter;

use Fig\Http\Message\StatusCodeInterface;
use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Ramsey\Uuid\Uuid;
use Sip\Psinder\Adoption\Application\Command\Pet;
use Sip\Psinder\Adoption\Application\Command\Shelter\PostOffer\PostOffer;
use Sip\Psinder\SharedKernel\Application\Command\CommandBus;
use function assert;

final class PostOfferRequestHandler implements RequestHandlerInterface
{
    /** @var CommandBus */
    private $commandBus;

    public function __construct(CommandBus $commandBus)
    {
        $this->commandBus = $commandBus;
    }

    public function handle(ServerRequestInterface $request) : ResponseInterface
    {
        /** @var PostOfferRequest|null $offerRequest */
        $offerRequest = $request->getAttribute(PostOfferRequest::class);

        if ($offerRequest === null) {
            return new JsonResponse(
                [
                    'message' => 'Bad request'
                ],
                StatusCodeInterface::STATUS_BAD_REQUEST
            );
        }

        $offerId = Uuid::uuid4()->toString();

        $pet       = $offerRequest->pet;
        $pet['id'] = Uuid::uuid4()->toString();

        $this->commandBus->dispatch(new PostOffer(
            $offerId,
            $offerRequest->shelterId,
            Pet::fromArray($pet)
        ));

        return new JsonResponse(['id' => $offerId]);
    }
}
