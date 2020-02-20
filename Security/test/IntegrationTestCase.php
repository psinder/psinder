<?php

declare(strict_types=1);

namespace Sip\Psinder\Security\Test;

use Sip\Psinder\SharedKernel\Test\ExpressiveIntegrationTestCase;

abstract class IntegrationTestCase extends ExpressiveIntegrationTestCase
{
    protected function containerPath() : string
    {
        return __DIR__ . '/../config/container.php';
    }
}
