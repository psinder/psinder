<?php

declare(strict_types=1);

namespace Sip\Psinder\Adoption\Test\Infrastructure\Persistence\InMemory;

use PHPUnit\Framework\TestCase;
use Sip\Psinder\Adoption\Domain\Offer\Offers;
use Sip\Psinder\Adoption\Infrastructure\Persistence\InMemory\InMemoryOffers;
use Sip\Psinder\Adoption\Test\Domain\Offer\OffersTest;
use Sip\Psinder\SharedKernel\Infrastructure\Testing\EventsInterceptingTest;

final class InMemoryOffersTest extends TestCase
{
    use OffersTest;
    use EventsInterceptingTest;

    /** @var InMemoryOffers */
    private $offers;

    protected function setUp() : void
    {
        $this->offers = InMemoryOffersFactory::create($this->eventPublisher());
    }

    protected function offers() : Offers
    {
        return $this->offers;
    }

    protected function context() : TestCase
    {
        return $this;
    }
}
