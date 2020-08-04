<?php

declare(strict_types=1);

namespace Sip\Psinder\SharedKernel\Application\Command;

use ArrayIterator;
use Countable;
use IteratorAggregate;
use Traversable;

use function count;
use function end;

/**
 * @implements IteratorAggregate<Command>
 */
final class InterceptingCommandBus implements CommandBus, Countable, IteratorAggregate
{
    /** @var Command[] */
    private array $commands;

    public function __construct()
    {
        $this->commands = [];
    }

    public function dispatch(Command $command): void
    {
        $this->commands[] = $command;
    }

    /**
     * @return Command[]
     */
    public function commands(): array
    {
        return $this->commands;
    }

    public function reset(): void
    {
        $this->commands = [];
    }

    public function count(): int
    {
        return count($this->commands);
    }

    /**
     * @return Command[]
     *
     * @phpstan-return Traversable<Command>
     */
    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->commands);
    }

    public function last(): ?Command
    {
        $last = end($this->commands);

        if ($last === false) {
            return null;
        }

        return $last;
    }
}
