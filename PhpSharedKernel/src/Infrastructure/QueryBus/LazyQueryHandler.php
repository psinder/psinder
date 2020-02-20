<?php

declare(strict_types=1);

namespace Sip\Psinder\SharedKernel\Infrastructure\QueryBus;

use Psr\Container\ContainerInterface;
use Sip\Psinder\SharedKernel\Application\Query\Query;
use Sip\Psinder\SharedKernel\Application\Query\QueryHandler;
use function assert;

final class LazyQueryHandler implements QueryHandler
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

    /**
     * @return mixed
     */
    public function __invoke(Query $query)
    {
        /** @var object|null $handler */
        $handler = $this->container->get($this->handlerId);

        assert($handler instanceof QueryHandler);

        return $handler->handle($query);
    }
}
