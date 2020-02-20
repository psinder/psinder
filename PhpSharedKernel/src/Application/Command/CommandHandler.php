<?php

declare(strict_types=1);

namespace Sip\Psinder\SharedKernel\Application\Command;

interface CommandHandler
{
    public function __invoke(Command $command) : void;
}
