<?php

declare(strict_types=1);

namespace Sip\Psinder\Security\Test;

use Doctrine\ORM\EntityManagerInterface;

abstract class TransactionalTestCase extends IntegrationTestCase
{
    protected function setUp() : void
    {
        parent::setUp();

        $this->em()->beginTransaction();
    }

    protected function tearDown() : void
    {
        $this->em()->rollback();

        parent::tearDown();
    }

    protected function em() : EntityManagerInterface
    {
        return $this->get(EntityManagerInterface::class);
    }
}
