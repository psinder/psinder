<?php

declare(strict_types=1);

namespace Sip\Psinder\SharedKernel\Infrastructure\Testing;

use PHPUnit\Framework\TestCase;

trait TestCaseAware
{
    abstract protected function context(): TestCase;
}
