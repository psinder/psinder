<?php

declare(strict_types=1);

namespace Sip\Psinder\Adoption\UI\Http\Shelter;

use Fig\Http\Message\StatusCodeInterface;
use Laminas\Diactoros\Response\EmptyResponse;
use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Sip\Psinder\Adoption\Application\Query\Offer\GetOfferDetails\GetOfferDetails;
use Sip\Psinder\SharedKernel\Application\Query\QueryBus;

final class GetOfferRequestHandler implements RequestHandlerInterface
{
    private QueryBus $queryBus;

    public function __construct(QueryBus $queryBus)
    {
        $this->queryBus = $queryBus;
    }

    public function handle(ServerRequestInterface $request) : ResponseInterface
    {
        $id     = $request->getAttribute('id');
        $result = $this->queryBus->execute(new GetOfferDetails($id));

        if ($result === null) {
            return new EmptyResponse(StatusCodeInterface::STATUS_NOT_FOUND);
        }

        return new JsonResponse($result->toArray());
    }
}
