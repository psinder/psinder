<?php

declare(strict_types=1);

namespace Sip\Psinder\SharedKernel\Test;

use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;
use Sip\Psinder\SharedKernel\Infrastructure\InterceptingEventPublisher;

abstract class ExpressiveIntegrationTestCase extends TestCase implements ContainerInterface
{
    protected ContainerInterface $container;
    /** @var callable[] */
    private array $testFactoryOverrides = [];
    /** @var string[] */
    private array $testAliasOverrides = [];

    protected function setUp(): void
    {
        $GLOBALS['TEST_FACTORY_OVERRIDES'] = $this->testFactoryOverrides;
        $GLOBALS['TEST_ALIAS_OVERRIDES']   = $this->testAliasOverrides;

        $this->container = require $this->containerPath();

        $GLOBALS['TEST_FACTORY_OVERRIDES'] = [];
        $GLOBALS['TEST_ALIAS_OVERRIDES']   = [];
    }

    protected function overrideServiceAliasWithInstance(string $id, object $instance): void
    {
        $implAlias = 'override_' . $id;

        $this->testFactoryOverrides[$implAlias] = static fn () => $instance;
        $this->testAliasOverrides[$id]          = $implAlias;
    }

    protected function overrideServiceInstance(string $id, object $instance): void
    {
        $this->testFactoryOverrides[$id] = static fn () => $instance;
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
     */
    public function has($id): bool
    {
        return $this->container->has($id);
    }

    protected function eventPublisher(): InterceptingEventPublisher
    {
        return $this->get(InterceptingEventPublisher::class);
    }

    abstract protected function containerPath(): string;
}
