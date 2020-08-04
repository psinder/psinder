<?php

declare(strict_types=1);

namespace Sip\Psinder\SharedKernel\Application\Command;

interface TransactionManager
{
    public function begin(): void;

    public function commit(): void;

    public function transactional(callable $fn): void;
}
