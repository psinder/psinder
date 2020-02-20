<?php

declare(strict_types=1);

namespace Sip\Psinder\Adoption\UI\Http\Shelter;

use Laminas\Diactoros\Response\EmptyResponse;
use Laminas\Diactoros\Response\JsonResponse;
use Mezzio\Router\RouteResult;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Sip\Psinder\Adoption\Application\Query\Shelter\GetOfferDetails\GetOfferDetails;
use Sip\Psinder\Adoption\Application\Query\Shelter\OfferDetails;
use Sip\Psinder\SharedKernel\Application\Query\QueryBus;
use function assert;

final class GetOfferRequestHandler implements RequestHandlerInterface
{
    /** @var QueryBus */
    private $queryBus;

    public function __construct(QueryBus $queryBus)
    {
        $this->queryBus = $queryBus;
    }

    public function handle(ServerRequestInterface $request) : ResponseInterface
    {
        /** @var RouteResult|null $routeResult */
        $routeResult = $request->getAttribute(RouteResult::class);

        assert($routeResult !== null);

        $id = $routeResult->getMatchedParams()['id'];

        $result = $this->queryBus->execute(new GetOfferDetails($id));

        if ($result === null) {
            return new EmptyResponse();
        }

        assert($result instanceof OfferDetails);

        return new JsonResponse($result->toArray());
    }
}
