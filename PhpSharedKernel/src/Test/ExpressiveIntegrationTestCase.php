<?php

declare(strict_types=1);

namespace Sip\Psinder\SharedKernel\Test;

use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;
use Sip\Psinder\SharedKernel\Infrastructure\InterceptingEventPublisher;

abstract class ExpressiveIntegrationTestCase extends TestCase implements ContainerInterface
{
    /** @var ContainerInterface */
    protected $container;

    protected function setUp() : void
    {
        $this->container = require $this->containerPath();
    }

    /**
     * @param mixed $id
     *
     * @return mixed
     */
    public function get($id)
    {
        return $this->container->get($id);
    }

    /**
     * @param mixed $id
     *
     * @return mixed
     */
    public function has($id)
    {
        return $this->container->has($id);
    }

    protected function eventPublisher() : InterceptingEventPublisher
    {
        return $this->get(InterceptingEventPublisher::class);
    }

    abstract protected function containerPath() : string;
}
