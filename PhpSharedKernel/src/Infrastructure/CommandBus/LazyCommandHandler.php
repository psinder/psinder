<?php

declare(strict_types=1);

namespace Sip\Psinder\SharedKernel\Infrastructure\CommandBus;

use Psr\Container\ContainerInterface;
use Sip\Psinder\SharedKernel\Application\Command\Command;
use Sip\Psinder\SharedKernel\Application\Command\CommandHandler;
use function assert;

final class LazyCommandHandler implements CommandHandler
{
    /** @var ContainerInterface */
    private $container;

    /** @var string */
    private $handlerId;

    public function __construct(ContainerInterface $container, string $handlerId)
    {
        $this->container = $container;
        $this->handlerId = $handlerId;
    }

    public function __invoke(Command $command) : void
    {
        /** @var object|null $handler */
        $handler = $this->container->get($this->handlerId);

        assert($handler instanceof CommandHandler);

        $handler->handle($command);
    }
}
