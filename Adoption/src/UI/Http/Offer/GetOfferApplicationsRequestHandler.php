<?php

declare(strict_types=1);

namespace Sip\Psinder\Adoption\UI\Http\Offer;

use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Sip\Psinder\Adoption\Application\Query\Offer\GetOfferApplications\GetOfferApplications;
use Sip\Psinder\SharedKernel\Application\Query\QueryBus;

final class GetOfferApplicationsRequestHandler implements RequestHandlerInterface
{
    private QueryBus $queryBus;

    public function __construct(QueryBus $queryBus)
    {
        $this->queryBus = $queryBus;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        return new JsonResponse(
            $this->queryBus->execute(new GetOfferApplications(
                $request->getAttribute('offerId')
            ))
        );
    }
}
