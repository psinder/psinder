<?php

declare(strict_types=1);

namespace Sip\Psinder\Adoption\Test\Infrastructure\Persistence\ORM;

use PHPUnit\Framework\TestCase;
use Sip\Psinder\Adoption\Domain\Offer\Offers;
use Sip\Psinder\Adoption\Infrastructure\Persistence\ORM\ORMOffers;
use Sip\Psinder\Adoption\Test\Domain\Offer\OffersTest;
use Sip\Psinder\Adoption\Test\TransactionalTestCase;

final class ORMOffersTest extends TransactionalTestCase
{
    use OffersTest;

    private ORMOffers $offers;

    public function setUp(): void
    {
        parent::setUp();

        $this->offers = $this->get(ORMOffers::class);
    }

    protected function offers(): Offers
    {
        return $this->offers;
    }

    protected function context(): TestCase
    {
        return $this;
    }
}
