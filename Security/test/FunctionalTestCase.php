<?php

declare(strict_types=1);

namespace Sip\Psinder\Security\Test;

use Helmich\Psr7Assert\Psr7Assertions;
use Sip\Psinder\SharedKernel\Test\ExpressiveFunctionalTestCase;

abstract class FunctionalTestCase extends ExpressiveFunctionalTestCase
{
    use Psr7Assertions;

    protected function containerPath(): string
    {
        return __DIR__ . '/../config/container.php';
    }
}
