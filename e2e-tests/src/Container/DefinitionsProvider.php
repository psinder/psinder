<?php

declare(strict_types=1);

namespace Sip\Psinder\E2E\Container;

abstract class DefinitionsProvider
{
    abstract public static function definitions() : array;
}
