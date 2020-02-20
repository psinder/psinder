<?php

declare(strict_types=1);

namespace Sip\Psinder\E2E\Container;

abstract class ContainerFactory
{
    protected static $container;

    public static function create()
    {
        if (!self::$container) {
            $builder = new \DI\ContainerBuilder();
            $builder->addDefinitions(static::definitions());

            self::$container = $builder->build();
        }

        return self::$container;
    }

    abstract protected static function definitions() : array;
}
