<?php

declare(strict_types=1);

namespace Sip\Psinder\Adoption\Application\Query\Offer\GetOfferDetails;

use Sip\Psinder\Adoption\Application\Query\Offer\OfferDetails;
use Sip\Psinder\Adoption\Application\Query\Offer\OfferRepository;
use Sip\Psinder\SharedKernel\Application\Query\Query;
use Sip\Psinder\SharedKernel\Application\Query\QueryHandler;
use function assert;

final class GetOfferDetailsHandler implements QueryHandler
{
    private OfferRepository $repository;

    public function __construct(OfferRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(Query $query) : ?OfferDetails
    {
        assert($query instanceof GetOfferDetails);

        return $this->repository->findDetails($query->id());
    }
}
