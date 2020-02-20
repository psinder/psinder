<?php

declare(strict_types=1);

namespace Sip\Psinder\Adoption\Test\Infrastructure\Persistence\ORM;

use PHPUnit\Framework\TestCase;
use Sip\Psinder\Adoption\Domain\Shelter\Shelters;
use Sip\Psinder\Adoption\Infrastructure\Persistence\ORM\ORMShelters;
use Sip\Psinder\Adoption\Test\Domain\Shelter\SheltersTest;
use Sip\Psinder\Adoption\Test\TransactionalTestCase;

final class ORMSheltersTest extends TransactionalTestCase
{
    use SheltersTest;

    /** @var ORMShelters */
    private $shelters;

    public function setUp() : void
    {
        parent::setUp();

        $this->shelters = $this->get(ORMShelters::class);
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
