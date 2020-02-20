<?php

declare(strict_types=1);

namespace Sip\Psinder\SharedKernel\Application\Command;

use Countable;
use Ds\Set;
use IteratorAggregate;

final class InterceptingCommandBus implements CommandBus, Countable, IteratorAggregate
{
    /** @var Set&Command[] */
    private $commands;

    public function __construct()
    {
        $this->commands = new Set();
    }

    public function dispatch(Command $command) : void
    {
        $this->commands->add($command);
    }

    /**
     * @return Command[]
     */
    public function commands() : array
    {
        return $this->commands->toArray();
    }

    public function reset() : void
    {
        $this->commands->clear();
    }

    public function count() : int
    {
        return $this->commands->count();
    }

    /**
     * @return Command[]
     */
    public function getIterator() : iterable
    {
        return $this->commands->getIterator();
    }

    public function last() : ?Command
    {
        return $this->commands->last();
    }
}
