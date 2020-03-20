<?php

declare(strict_types=1);

namespace Sip\Psinder\Adoption\Test\Infrastructure\Persistence\InMemory;

use PHPUnit\Framework\TestCase;
use Sip\Psinder\Adoption\Domain\Adopter\Adopters;
use Sip\Psinder\Adoption\Infrastructure\Persistence\InMemory\InMemoryAdopters;
use Sip\Psinder\Adoption\Test\Domain\Adopter\AdoptersTest;
use Sip\Psinder\SharedKernel\Infrastructure\Testing\EventsInterceptingIsolatedTest;

final class InMemoryAdoptersTest extends TestCase
{
    use AdoptersTest;
    use EventsInterceptingIsolatedTest;

    /** @var InMemoryAdopters */
    private $adopters;

    public function setUp() : void
    {
        $this->adopters = new InMemoryAdopters($this->eventPublisher());
    }

    protected function adopters() : Adopters
    {
        return $this->adopters;
    }

    protected function context() : TestCase
    {
        return $this;
    }
}
