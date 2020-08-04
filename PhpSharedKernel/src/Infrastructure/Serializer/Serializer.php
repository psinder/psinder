<?php

declare(strict_types=1);

namespace Sip\Psinder\SharedKernel\Infrastructure\Serializer;

interface Serializer
{
    /** @param mixed[]|object $value */
    public function serialize($value): string;

    public function deserialize(string $value, string $type): object;
}
