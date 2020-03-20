<?php

declare(strict_types=1);

namespace Sip\Psinder\Adoption\Test\Infrastructure\Persistence\InMemory;

use PHPUnit\Framework\TestCase;
use Sip\Psinder\Adoption\Domain\Shelter\Shelters;
use Sip\Psinder\Adoption\Infrastructure\Persistence\InMemory\InMemoryShelters;
use Sip\Psinder\Adoption\Test\Domain\Shelter\SheltersTest;
use Sip\Psinder\SharedKernel\Infrastructure\Testing\EventsInterceptingIsolatedTest;

final class InMemorySheltersTest extends TestCase
{
    use SheltersTest;
    use EventsInterceptingIsolatedTest;

    /** @var Shelters */
    private $shelters;

    public function setUp() : void
    {
        $this->shelters = new InMemoryShelters($this->eventPublisher());
    }

    protected function shelters() : Shelters
    {
        return $this->shelters;
    }

    protected function context() : TestCase
    {
        return $this;
    }
}
