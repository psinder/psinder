<?php

declare(strict_types=1);

namespace Sip\Psinder\Adoption\Application\Query\Offer\GetOfferApplications;

use Sip\Psinder\Adoption\Application\Query\Offer\OfferApplication;
use Sip\Psinder\Adoption\Application\Query\Offer\OfferRepository;
use Sip\Psinder\SharedKernel\Application\Query\Query;
use Sip\Psinder\SharedKernel\Application\Query\QueryHandler;

use function assert;

final class GetOfferApplicationsHandler implements QueryHandler
{
    private OfferRepository $repository;

    public function __construct(OfferRepository $repository)
    {
        $this->repository = $repository;
    }

    /** @return OfferApplication[] */
    public function __invoke(Query $query): array
    {
        assert($query instanceof GetOfferApplications);

        return $this->repository->getApplications($query->id());
    }
}
