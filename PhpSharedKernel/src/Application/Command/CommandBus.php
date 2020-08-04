<?php

declare(strict_types=1);

namespace Sip\Psinder\SharedKernel\Application\Command;

interface CommandBus
{
    public function dispatch(Command $command): void;
}
