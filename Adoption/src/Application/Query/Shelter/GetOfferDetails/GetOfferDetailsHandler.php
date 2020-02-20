<?php

declare(strict_types=1);

namespace Sip\Psinder\Adoption\Application\Query\Shelter\GetOfferDetails;

use Sip\Psinder\Adoption\Application\Query\Shelter\OfferDetails;
use Sip\Psinder\Adoption\Application\Query\Shelter\OfferDetailsRepository;
use Sip\Psinder\SharedKernel\Application\Query\Query;
use Sip\Psinder\SharedKernel\Application\Query\QueryHandler;
use function assert;

final class GetOfferDetailsHandler implements QueryHandler
{
    /** @var OfferDetailsRepository */
    private $repository;

    public function __construct(OfferDetailsRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(Query $query) : ?OfferDetails
    {
        assert($query instanceof GetOfferDetails);

        return $this->repository->find($query->id());
    }
}
